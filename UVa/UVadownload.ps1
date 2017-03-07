if($Host.Version.Major -le 2) 
{
    Write-Host "Your Powershell Version is too low." -ForegroundColor Red
    Write-Host "Exiting..." -ForegroundColor Green
    Exit-PSHostProcess 1
};
Trap
{
    Write-Host "[Error]" -ForegroundColor Red -NoNewline
    Write-Host "The script is terminated unexpectedly."
    "$Error"
}
[datetime]$beginatttime=Get-Date
for($volume=1;$volume -le 131 ;$volume++)
{
    if(($volume -ge 10) -and ($volume -le 99))
    {
        continue
    }
    Write-Host "[Starting]" -ForegroundColor Green -NoNewline
    Write-Host " Volume " -NoNewline
    Write-Host $volume -ForegroundColor Cyan -NoNewline
    Write-Host " ..."
    New-Item -ItemType Directory -Name $volume -ErrorAction "SilentlyContinue" | Out-Null
    Set-Location $volume
    $L=$volume*100
    $R=$L+100
    [datetime]$begin=Get-Date
    for($id=$L;$id -lt $R;$id++)
    {
        [datetime]$beginat=Get-Date
        Write-Host "[Starting]" -ForegroundColor Green -NoNewline
        Write-Host " to download " -NoNewline
        Write-Host $id -ForegroundColor Cyan -NoNewline
        Write-Host " in UVa Volume " -NoNewline
        Write-Host $volume -ForegroundColor Cyan -NoNewline
        Write-Host " ..."
        [string]$Site="https://uva.onlinejudge.org/external/$volume/$id.pdf"
        [String]$FileName=Split-Path -Leaf $Site
        Invoke-WebRequest -TimeoutSec 30 -OutFile $FileName -Uri $Site -ErrorAction "Continue"
        if($?)
        {
            [datetime]$endat=Get-Date
            [timespan]$spendat=$endat-$beginat
            Write-Host "[  OK  ]" -ForegroundColor Green -NoNewline
            Write-Host " Downloaded " -NoNewline
            Write-Host $id -ForegroundColor Cyan -NoNewline
            Write-Host " in UVa Volume " -NoNewline
            Write-Host $volume -ForegroundColor Cyan -NoNewline
            Write-Host " in " -NoNewline
            Write-Host $spendat.Seconds -ForegroundColor Green -NoNewline
            Write-Host " seconds."
        }
        else
        {
            Write-Host "[Failed]" -ForegroundColor Red -NoNewline
            Write-Host " to download " -NoNewline
            Write-Host $id -ForegroundColor Cyan -NoNewline
            Write-Host " in UVa Volume " -NoNewline
            Write-Host $volume -ForegroundColor Cyan -NoNewline
            Write-Host " ." -NoNewline
        }
    }    
    [datetime]$end=Get-Date
    [timespan]$spend=$end-$begin
    Write-Host "[Finished]" -ForegroundColor Green -NoNewline
    Write-Host " Volume " -NoNewline
    Write-Host $volume -ForegroundColor Cyan -NoNewline
    Write-Host " in " -NoNewline
    Write-Host $spend.Seconds -ForegroundColor Green -NoNewline
    Write-Host " seconds."
    Set-Location ..
}
[datetime]$endattime=Get-Date
[timespan]$spendattime=$endattime-$beginatttime
Write-Host "[  OK  ]" -ForegroundColor Green -NoNewline
Write-Host " Action Finished in " -NoNewline
Write-Host $spendattime.Minutes -ForegroundColor Cyan -NoNewline
Write-Host " minutes."
"$Error"
from PIL import Image

def loadImage(filename):
	img = Image.open(filename)
	width, height = img.size
	img = img.convert("RGB")
	pixel = img.load()
	return width, height, pixel 

w1,h1,p1=loadImage("old.png")

img=Image.new("RGB",(w1,h1))
pix=img.load()

for y in xrange(0,h1):
	for x in xrange(0,w1):
		r,g,b=p1[x,y]
		pix[x,y]=r,g|1,b

w2,h2,p2=loadImage("1481021344.png")
for y in xrange(0,h2):
	for x in xrange(0,w2):
		r,g,b=p1[x,y]
		rr,gg,bb=p2[x,y]
		if(rr<20):
			r,g,b=r,g-1,b
		pix[x,y]=r,g,b

img.save("stage.png")

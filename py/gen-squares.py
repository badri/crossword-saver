import Image, ImageFont, ImageDraw, ImageChops

fontfile = r"C:\WINDOWS\Fonts\arialbd.ttf"
position = (1,1)
color = "#000000"
size = 10

for i in range(1,60,1):
    text = str(i)
    # A fully transparent image to work on, and a separate alpha channel.
    im = Image.new("RGB", (30, 30), (0,0,0))
    alpha = Image.new("L", im.size, "black")

    # Make a grayscale image of the font, white on black.
    imtext = Image.new("L", im.size, 0)
    drtext = ImageDraw.Draw(imtext)
    font = ImageFont.truetype(fontfile, size)
    drtext.text(position, text, font=font, fill="white")
        
    # Add the white text to our collected alpha channel. Gray pixels around
    # the edge of the text will eventually become partially transparent
    # pixels in the alpha channel.
    alpha = ImageChops.lighter(alpha, imtext)

    # Make a solid color, and add it to the color layer on every pixel
    # that has even a little bit of alpha showing.
    solidcolor = Image.new("RGBA", im.size, color)
    immask = Image.eval(imtext, lambda p: 255 * (int(p != 0)))
    im = Image.composite(solidcolor, im, immask)

    # These two save()s are just to get demo images of the process.
    # im.save("transcolor.png", "PNG")
    # alpha.save("transalpha.png", "PNG")

    # Add the alpha channel to the image, and save it out.
    im.putalpha(alpha)
    im.save(text+".png", "PNG")

@import <AppKit/CPView.j>

@implementation SquareView : CPView
{
    CPImageView imageView;
}

- (void)setRepresentedObject:(id)anObject
{    
    if([anObject code] == "1") {
        [self setBackgroundColor: [CPColor whiteColor]];
    }
    else {
        [self setBackgroundColor: [CPColor blackColor]];
    }

    if (!imageView)
    {
        imageView = [[CPImageView alloc] initWithFrame:CGRectMake(0.0, 0.0, 30.0, 30.0)];
        
        [imageView setImageScaling:CPScaleProportionally];
    
        if([anObject grid] !== "") {
            var Img = [[CPImage alloc] initWithContentsOfFile:@"Resources/sq/"+[anObject grid]+".png"];
            [imageView setImage:Img];
        }

        [self addSubview:imageView];
    }


}

- (void)setSelected:(BOOL)isSelected
{
    [self setBackgroundColor:isSelected ? [CPColor colorWithHexString:"3d80df"] : nil];
}

@end

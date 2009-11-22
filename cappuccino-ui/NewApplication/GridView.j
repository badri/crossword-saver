@import <AppKit/CPCollectionView.j>

@implementation GridView : CPCollectionView
{
    CPCollectionViewItem itemPrototype;
}

- (id)initWithFrame:(CGRect)aFrame
{
    self = [super initWithFrame:aFrame];
    if (self)
    {
        [self setMinItemSize:CGSizeMake(CGRectGetWidth([self bounds]), 225)];
        [self setMaxItemSize:CGSizeMake(CGRectGetWidth([self bounds]), 225)];
        [self setMaxNumberOfRows:15];
        [self setMaxNumberOfColumns:15];
    
        itemPrototype = [[CPCollectionViewItem alloc] init];
        [itemPrototype setView:[[SquareView alloc] initWithFrame:CGRectMakeZero()]];
        [self setItemPrototype:itemPrototype];
    }

    return self;
}

- (id)getCurrentObject
{
    return [[self content] objectAtIndex:[self getSelectedIndex]] ;
}

- (int)getSelectedIndex
{
    return [[self selectionIndexes] firstIndex] ;
}

@end

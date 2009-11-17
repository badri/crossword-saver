@import <Foundation/CPObject.j>

@implementation Square : CPObject
{
    CPString code @accessors;
    CPString grid @accessors;
}

- (id)init
{
    self = [super init];
    
    if (self)
    {
        code   = @"";
        grid    = @"";
    }
    return self;
}

- (id)initFromJSONObject:(CPString)aJSONObject
{
    self = [self init];
    if (self)
    {
        code = aJSONObject.code;
        grid = aJSONObject.grid;
    }
    return self;
}

+ (CPArray)initFromJSONObjects:(CPString)someJSONObjects
{
    var grid = [[CPArray alloc] init];
    
    for (var i=0; i < someJSONObjects.length; i++) {
        var square = [[Square alloc] initFromJSONObject:someJSONObjects[i].square];
        [grid addObject:square];
    };
    return grid;
}

+ (CPArray)getExampleGrid
{
    var array   = [[CPArray alloc] init];
    var square    = [[Square alloc] init];
    
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"1"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"2"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"3"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"4"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"5"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"6"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"7"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"8"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"9"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"10"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"11"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"12"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"13"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"14"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"15"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"16"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"17"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"18"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"19"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"20"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"21"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"22"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"23"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"24"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"25"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"26"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"27"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"28"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"29"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"30"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@"31"];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"1"];
    [square setGrid:@""];
    [array addObject:square];

    square   = [[Square alloc] init];
    [square setCode:@"0"];
    [square setGrid:@""];
    [array addObject:square];
                
    return array ;
}

@end

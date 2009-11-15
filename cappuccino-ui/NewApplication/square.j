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

@end

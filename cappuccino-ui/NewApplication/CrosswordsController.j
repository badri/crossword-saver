@import <Foundation/CPObject.j>

@implementation CrosswordsController : CPObject
{
    GridView            gridView @accessors;
    CPString                baseURL;
    CPCollectionViewItem    currentObject;
    CPURLConnection         listConnection;
}

- (id)init
{
    self = [super init] ;
    
    if (self)
    {
        baseURL = "http://127.0.0.1:8000";
    }
    
    return self;
}

- (void)collectionViewDidChangeSelection:(CPCollectionView)collectionView
{
    currentObject = [collectionView getCurrentObject];
}


- (void)loadPosts
{
    var request     = [CPURLRequest requestWithURL:baseURL + "/posts.json"];
    [request setHTTPMethod: "GET"];
    listConnection  = [CPURLConnection connectionWithRequest:request delegate:self];
}

- (void)connection:(CPURLConnection)connection didReceiveData:(CPString)data
{
    if (connection===listConnection)
    {
        var results = CPJSObjectCreateWithJSON(data);
        var grid = [Square initFromJSONObjects:results];
        
        [gridView setContent:grid];
        [gridView setSelectionIndexes:[[CPIndexSet alloc] initWithIndex:0] ];
    }
}

- (void)connection:(CPURLConnection)connection didFailWithError:(CPString)error
{
    alert("Connection did fail with error : " + error);
}

- (void)connectionDidFinishLoading:(CPURLConnection)aConnection
{
    console.log("Connection did finish loading.");
}
@end

#include<iostream>
#include<cmath>

using namespace std;

int main()
{
    float x,y;
    
    cin>>x;
    
    x = x/2;
    
    y = (x) - int(x);
    
    if(x==y)
    {
        cout<<"polvo";
    }
    else
    {
        cout<<"Lula";
    }
    
    return 0;
}

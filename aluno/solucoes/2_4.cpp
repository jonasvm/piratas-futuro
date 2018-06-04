#include <stdio.h>
#include <iostream>
using namespace std;

int main(){
	int x = 10;
	x = x/2;
	if(x%2 == 0)
		std::cout<<"polvo"<<std::endl;
	else
		std::cout<<"lula"<<std::endl;
	return 0;
}

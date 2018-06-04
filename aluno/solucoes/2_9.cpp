#include <stdio.h>
#include <iostream>
using namespace std;

int main(){
	float x = 250;
	x = 250*0.24;
	std::cout<<x<<" ";
	x = 250*0.48;
	std::cout<<x<<" ";
	x = 250*(1-0.24-0.48);
	std::cout<<x<<std::endl;
	return 0;
}

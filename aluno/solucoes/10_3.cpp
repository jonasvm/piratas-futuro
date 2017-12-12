#include <iostream>

using namespace std;

int fatorial (int n)
{   
    int i;
    i = n - 1; 
    for (i; i!=1; i--)
        n = n * i;
    return n;
}

int main() {
	int pares=0, impares=0;

	for(int i=1; i<=11; i++) {
		if(i%2 == 0)
			pares += fatorial(i);
		else
			impares += fatorial(i);
	}

	cout << impares << " " << pares;

	return 1;
}

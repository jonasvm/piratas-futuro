#include <iostream>

using namespace std;

int fat (int N) {

		if((N == 1) || (N == 0))
			return N;
		else
			return (fat(N-1)*N);
}

int main() {
    int soma=0;

    for(int i=1; i<=10; i++)
        if(i%2 != 0)
            soma += fat(i);

	cout << soma;

	return 1;
}


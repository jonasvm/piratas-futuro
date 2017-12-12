#include <iostream>

using namespace std;

int main() {
	int vet[6] = {33, 23, 56, 14, 96, 62}, soma;

	for(int i=0; i<6; i++) {
		for(int j=i; j<6; j++) {
			if(vet[i] + vet[j] == 129)
				soma = vet[i] + vet[j];
		}
	}
	cout << soma;

	return 1;

}

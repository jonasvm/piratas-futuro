/*Atravessando a Montanha de Madagascar, você caiu em um buraco, e isto levou para uma galeria no interior da montanha onde
você encontrou vários pergaminhos de uma civilização antiga. No total, eram 10 pergaminhos que estão em ordem decrescente,
coloque-os em ordem crescente para ver  se descobre algo que ajudará em sua jornada.
10 9 8 7 6 5 4 3 2 1
1 2 3 4 5 6 7 8 9 10*/

#include <iostream>
#include <cstdlib>

using namespace std;

int main() {

    int vet[10] = {10, 9, 8, 7, 6, 5, 4, 3, 2, 1}, j=9, aux;

    for(int i=0; i<5; i++) {
        aux = vet[i];
        vet[i] = vet[j];
        vet[j] = aux;
        j--;
    }

    for(int k=0; k<10; k++) {
        cout << vet[k];
        if(k!=9)
            cout << " ";
    }

    return 1;

}


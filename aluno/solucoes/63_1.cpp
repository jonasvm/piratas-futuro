/*Você está preso em uma das celas de “Nova Alcatraz”, as celas dessa prisão são trancadas por um dispositivo eletrônico,
e são desbloqueados com uma sequência de números. Por sorte, você estudou sobre este tipo de dispositivo no campo de
refugiados e sabe que a sequência de número padrão é [33 23 56 14 96 62]. O código sempre é a soma de dois destes números.
Seja rápido, os guardas costumam fazer sua ronda de 30 em 30 minutos...
33 23 56 14 96 62
129*/

#include <iostream>
#include <cstdlib>

using namespace std;

int main() {

    int vet[6] = {33, 23, 56, 14, 96, 62}, soma;

    for(int i=0; i<=6; i++) {
        for(int j=i; j<6; j++){
            if(vet[i] + vet[j] == 129)
                cout << vet[i] + vet[j];
        }
    }

    return 1;

}

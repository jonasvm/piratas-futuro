/*Voc� est� preso em uma das celas de �Nova Alcatraz�, as celas dessa pris�o s�o trancadas por um dispositivo eletr�nico,
e s�o desbloqueados com uma sequ�ncia de n�meros. Por sorte, voc� estudou sobre este tipo de dispositivo no campo de
refugiados e sabe que a sequ�ncia de n�mero padr�o � [33 23 56 14 96 62]. O c�digo sempre � a soma de dois destes n�meros.
Seja r�pido, os guardas costumam fazer sua ronda de 30 em 30 minutos...
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

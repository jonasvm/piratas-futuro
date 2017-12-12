/*Você acaba de chegar à famosa cidade do México em sua jornada, e descobre que ela foi tomada pelo governador,
que colocou seus melhores capangas em pontos estratégicos na cidade, sua missão é libertar a cidade das mãos desses
opressores. De acordo com um morador, os capangas estão escondidos em pontos cuja coordenada x é a soma de todos os
fatoriais dos números impares entre 0 e 5, e a coordenada y é a soma de todos os fatoriais dos números pares no mesmo
intervalo . Não será fácil derrotá-los, encontre-os antes que seja notado...
(Sem entrada)
40284846 3669866*/

#include <iostream>
#include <cstdlib>

using namespace std;

int fat(int N) {
    if(N == 0)
        return 1;
    else
        return N*fat(N-1);
}

int main() {
    int pares=0, imp=0;

    for(int i=0; i<=11; i++) {
        if(i%2 == 0)
            pares += fat(i);
        else
            imp += fat(i);
    }

    cout << imp << " " << pares;

    return 1;

}

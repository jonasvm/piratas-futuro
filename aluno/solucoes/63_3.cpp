/*Voc� acaba de chegar � famosa cidade do M�xico em sua jornada, e descobre que ela foi tomada pelo governador,
que colocou seus melhores capangas em pontos estrat�gicos na cidade, sua miss�o � libertar a cidade das m�os desses
opressores. De acordo com um morador, os capangas est�o escondidos em pontos cuja coordenada x � a soma de todos os
fatoriais dos n�meros impares entre 0 e 5, e a coordenada y � a soma de todos os fatoriais dos n�meros pares no mesmo
intervalo . N�o ser� f�cil derrot�-los, encontre-os antes que seja notado...
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

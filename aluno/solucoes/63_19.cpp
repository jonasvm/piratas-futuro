/*Você foi selecionado para comandar um treinamento de um novo pelotão. Você poderá dar um prêmio para o que tiver maior
pontuação nas provas do final do curso. No total são 7 novos recrutas. Reveja as provas, cujas notas são [50 72 29 75 89 62 10],
veja qual foi o melhor e nomeie sargento.

50 72 29 75 89 62 10
89*/

#include <iostream>
#include <cmath>

using namespace std;

int main() {

    int vet[7] = {50, 72, 29, 75, 89, 62, 10}, maior = vet[0];

    for(int i=0; i<7; i++) {
        if(vet[i] > maior)
            maior = vet[i];
    }
    cout << maior;
    return 1;

}

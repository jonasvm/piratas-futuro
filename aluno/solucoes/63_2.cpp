/*Você encontrou os restos mortais de um dos governadores do século XXI, um dos primeiros piratas sanguinários dessa época.
Sua missão é decifrar a senha que desbloqueará o cofre que está sobre sua sepultura, a senha é a idade exata em que ele
faleceu.  De acordo com sua análise, sua morte ocorreu há exatamente 950 anos (considerando a data atual, 20 de abril de 3016),
e de acordo com as inscrições da tumba sua data de nascimento é a mesma da queda do muro de Berlin. Seja rápido! Você não é o
único procurando pelas informações do cofre... (Atenção, os dias e mês  podem influenciar na idade)
(Sem entrada)
76*/

#include <iostream>
#include <cstdlib>

using namespace std;

int main() {

    int idade;

    idade = ((3016 - 950) - 1989) - 1;

    cout << idade;

    return 1;

}

/*Voc� encontrou os restos mortais de um dos governadores do s�culo XXI, um dos primeiros piratas sanguin�rios dessa �poca.
Sua miss�o � decifrar a senha que desbloquear� o cofre que est� sobre sua sepultura, a senha � a idade exata em que ele
faleceu.  De acordo com sua an�lise, sua morte ocorreu h� exatamente 950 anos (considerando a data atual, 20 de abril de 3016),
e de acordo com as inscri��es da tumba sua data de nascimento � a mesma da queda do muro de Berlin. Seja r�pido! Voc� n�o � o
�nico procurando pelas informa��es do cofre... (Aten��o, os dias e m�s  podem influenciar na idade)
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

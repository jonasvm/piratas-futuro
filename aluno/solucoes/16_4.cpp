/*Em alto mar, voc� avista uma criatura gigante rara com tent�culos, mas devido a pouca visibilidade por causa da �gua, voc�
n�o consegue identificar se � um polvo ou uma lula. Para isso, voc� decide utilizar a c�mera de raios-X do seu computador de
bordo para visualizar. Se a metade dos tent�culos for um n�mero impar, ser� uma lula, caso contr�rio ser� um polvo. Tente
identificar, pois se voc� espalhar a not�cia de que encontrou um animal raro desse, muitos ca�adores poder�o lhe recompensar
por tal informa��o.
10
lula*/

#include <iostream>
#include <cstdlib>

using namespace std;

int main() {

    int tentaculos = 10;

    if((tentaculos/2)%2 == 0)
        cout << "polvo";
    else
        cout << "lula";

    return 1;

}


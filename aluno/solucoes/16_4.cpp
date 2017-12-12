/*Em alto mar, você avista uma criatura gigante rara com tentáculos, mas devido a pouca visibilidade por causa da água, você
não consegue identificar se é um polvo ou uma lula. Para isso, você decide utilizar a câmera de raios-X do seu computador de
bordo para visualizar. Se a metade dos tentáculos for um número impar, será uma lula, caso contrário será um polvo. Tente
identificar, pois se você espalhar a notícia de que encontrou um animal raro desse, muitos caçadores poderão lhe recompensar
por tal informação.
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


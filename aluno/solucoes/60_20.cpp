/*O último responsável pelo bloco de armas o deixou completamente desorganizado. Agora você terá que fazer um inventário de
cada arma nesta sala. São 250 armas classificadas em brancas, média e de fogo, sendo que 24% são brancas, 48% são média e o
restante de fogo. Verifique quantas têm de cada uma dessas e entregue o relatório para seu chefe.
250
60 120 70*/

#include <iostream>
#include <cmath>

using namespace std;

int main() {

    int total = 250;

    cout << total*0.24 << " " << total*0.48 << " " << total*0.28;

    return 1;

}


/*O �ltimo respons�vel pelo bloco de armas o deixou completamente desorganizado. Agora voc� ter� que fazer um invent�rio de
cada arma nesta sala. S�o 250 armas classificadas em brancas, m�dia e de fogo, sendo que 24% s�o brancas, 48% s�o m�dia e o
restante de fogo. Verifique quantas t�m de cada uma dessas e entregue o relat�rio para seu chefe.
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


/*Para seu azar sua bolsa rasgou e voc� s� percebeu ao ter atravessado a floresta toda. Muitos itens seus ca�ram pelo caminho.
Agora ter� que fazer todo o caminho contr�rio para encontr�-los novamente. No total a floresta tem uma �rea de 30x50km. Voc�
sabe que existe um item a cada 60,6Km2. Vasculhe toda a �rea e descubra quantos itens voc� perdeu.
1500
24*/

#include <iostream>
#include <cmath>

using namespace std;

int main() {

    int area = 30*50;

    cout << floor(area/60.6);

    return 1;

}

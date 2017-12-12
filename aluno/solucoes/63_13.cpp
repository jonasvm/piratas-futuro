/*Para seu azar sua bolsa rasgou e você só percebeu ao ter atravessado a floresta toda. Muitos itens seus caíram pelo caminho.
Agora terá que fazer todo o caminho contrário para encontrá-los novamente. No total a floresta tem uma área de 30x50km. Você
sabe que existe um item a cada 60,6Km2. Vasculhe toda a área e descubra quantos itens você perdeu.
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

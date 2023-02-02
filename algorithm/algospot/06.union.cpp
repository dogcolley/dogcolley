#include <iostream>
#include <stdio.h>
using namespace std;

//공용체
union ShareData {
    unsigned char a;
    unsigned short b;
    unsigned int c;

};

//열거체
enum Weather {SUNNY = 0, CLOUD = 10, RAIN = 20, SNOW = 30};

int main(void)

{
    //공용체 예시
    ShareData var;
    var.c = 0x12345678;

    cout << hex;
    cout << var.a << endl;
    cout << var.b << endl;
    cout << var.c << endl;

    //열거체 예시
    int input;
    Weather wt;

    cout << "오늘의 날씨를 입력해 주세요 : " << endl;
    cout << "(SUNNY=0, CLOUD=10, RAIN=20, SNOW=30)" << endl;
    //cin >> input;
    input = 0;
    wt = (Weather)input;
    switch (wt)
    {
        case SUNNY:
            cout << "오늘의 날씨는 아주 맑아요!";
            break;
        case CLOUD:
            cout << "오늘의 날씨는 흐리네요!";
            break;
        case RAIN:
            cout << "오늘의 날씨는 비가 주룩주룩 오네요!";
            break;
        case SNOW:
            cout << "오늘의 날씨는 하얀 눈이 내려요!";
            break;
        default:
            cout << "정확한 상숫값을 입력해 주세요!";
            break;
    }
    cout << "test end " << endl;
    cout << endl << "열거체 Weather의 각 상숫값은 " << SUNNY << ", " << CLOUD << ", "<< RAIN << ", " << SNOW << "입니다.";

}
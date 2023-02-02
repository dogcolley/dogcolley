#include <iostream>
using namespace std;

//Calculator 와 Calculator2의 차이는 매게변수의 함수를 상단에 타입을 정의해서 사용 하는 것 

double Add(double, double);
double Sub(double, double);
double Mul(double, double);
double Div(double, double);
double Calculator(double , double, double (*func)(double, double));

typedef double (*Arith)(double, double);
double Calculator2(double , double, Arith);

int main (void){
    double (*calc)(double, double) = NULL; // 함수 포인터 선언
    Arith calc2 = NULL; // 함수 포인터 선언
    double num1 = 3, num2 = 4, result = 0;
    char oper = '+';
 
    switch (oper)
    {
        case '+' :
            calc = Add;
            break;
        case '-':
            calc = Sub;
            break;
        case '*':
            calc = Mul;
            break;
        case '/':
            calc = Div;
            break;
        default:
            cout << "사칙연산(+, -, *, /)만을 지원합니다.";
            break;
    }

    result = Calculator(num1, num2, calc);
    cout << "사칙 연산의 결과는 " << result << "입니다." << endl;

    calc2 = calc;
    result = Calculator2(num1, num2, calc);
    cout << "사칙 연산의 결과는 " << result << "입니다.";

}

//포인터 함수의 경우 하단에 정의 되든 상단에 정의되든 최상위로 올라갑니다.
double Add        (double num1, double num2) { return num1 + num2; }
double Sub        (double num1, double num2) { return num1 - num2; }
double Mul        (double num1, double num2) { return num1 * num2; }
double Div        (double num1, double num2) { return num1 / num2; }
double Calculator (double num1, double num2, double (*func)(double, double)) { return func(num1, num2); }
double Calculator2(double num1, double num2, Arith func) { return func(num1, num2); }
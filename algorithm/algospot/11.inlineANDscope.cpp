#include <iostream>
using namespace std;

inline int Sub(int x, int y) { return x - y; }

inline void Print(int x) { cout << "계산 결과는 " << x << "입니다."; }

int main(void)
{
    int num1 = 5, num2 = 3;
    int result;
    result = Sub(num1, num2);
    Print(result);

    //지역변수 타입
    {
        int x = num1, y = num2;
        result = x - y;
    }
    {
        int x = result;
        cout << "계산 결과는 " << x << "입니다.";
    }

}


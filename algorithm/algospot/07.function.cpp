#include <iostream>
using namespace std;

int SmallNum(int num1, int num2)
{
    if (num1 <= num2)

    {
        return num1;
    }
    else
    {
        return num2;
    }
}
 
void Local(int);
void Local(int num)
{
    num += 10;
}
void Local2(int&);
void Local2(int& num)
{
    num += 10;
}



int main(void)
{
    int result;  
    result = SmallNum(4, 6);
    cout << " 두 수 중 더 작은 수는 " << result << "입니다." << endl;
    result = SmallNum(8, 6);
    cout << " 두 수 중 더 작은 수는 " << result << "입니다." << endl;
    result = SmallNum(2, 8);
    cout << " 두 수 중 더 작은 수는 " << result << "입니다." << endl;

    int var = 10;
    cout << "변수 var의 초깃값은 " << var << "입니다." << endl;
    Local(var); //var의 값은 바뀌지 않음
    cout << "Local() 함수 호출 후 변수 var의 값은 " << var << "입니다."<< endl;
    Local2(var); //var 의 값이 바뀜 
    cout << "Local2() 함수 호출 후 변수 var의 값은 " << var << "입니다."<< endl;

}


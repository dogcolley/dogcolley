#include <iostream>
using namespace std;


int RecursiveSum(int n)
{
    if(n==1)
        return 1;
    
    return n + RecursiveSum(n-1);
}

int main(){
    int num = 10;
    cout << "num의 값은 : " << num << endl;
    cout << "재귀함수 RecursiveSum 을 사용시 : " << RecursiveSum(num) << endl;
} 




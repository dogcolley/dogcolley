#include <iostream>
using namespace std;

void Shift(int, int);
void Shift(int, int, int);
void Shift(int, int, int, int);

int main(void)
{
	Shift(1, 2);
	Shift(1, 2, 3);
	Shift(1, 2, 3, 4);
	return 0;
}

void Shift(int a, int b)
{
	int temp;
	
	temp = a;
	a = b;
	b = temp;
	
	cout << a << ", " << b << endl;
}

void Shift(int a, int b, int c)
{
	int temp;
	
	temp = a;
	a = b;
	b = c;
	c = temp;
	
	cout << a << ", " << b << ", " << c << endl;
}

void Shift(int a, int b, int c, int d)
{
	int temp;
	
	temp = a;
	a = b;
	b = c;
	c = d;
	d = temp;
	
	cout << a << ", " << b << ", " << c << ", " << d << endl;
}
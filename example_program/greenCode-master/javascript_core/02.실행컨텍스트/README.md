# 02.실행컨텍스트

<br>

## 실행 컨텍스트란?
<br>


>in 이후 a => b => c => d 순으로 이벤트가 실행되고 out 된다.

| 스택방식 | 
|---|
|d|
|c|
|b|
|a|

<br>

>in 이후 a 실행후 b 실행후, c실행후, d가 실행됩니다.

| 큐방식 ||||
|---|:---:|:---:|:---:|
|d|c|b|a|

<br>

>실행 컨텍스트와 콜 스택의 

1. 전역 컨텍스트 실행
2. outer 함수실행
3. inner 함수실행
4. inner 함수완료 소멸
5. outer 함수완료 소멸
6. 전역 컨텍스트 소멸

```
var a = 1;
function outer(){
    function inner(){
        console.log('inner',a); //undefined , 스냅샷으로 값이 방영되지 않습니다.
        var a = 3; 
    }
    inner();
    console.log(a);  // 1
    console.log(b);  // undefined
    var b = 5 ;

    inner2() // 호이스팅

    function inner2(){
        var c = 3;
        console.log('inner2',a); //undefined , 스냅샷으로 값이 방영되지 않습니다.
        console.log(c); // 3
    }
}
outer();
console.log(a); // 1
```

>VariableEnvironment : 현재 컨텍스트 내의 식별자들에 대한 정보 + 외부 환경 <br>
LexicalEnvironment 의 스냅샷 으로 변경되도 방영되지 않음
>>LexicalEnvironment와 담기는 내용은 같지만 최초 실행되는 스냅샷이 다르다.
후 코드 진행에 따라 달라집니다.

<br>

>LexicalEnvironment : 처음에는 VariableEnvironment와 같지만 실시간으로 방영됨
>>정적이라는 의미를 가진 단어이지만 매번 변경되는 환경에 크게 의미가 매칭되지 않습니다. '사전적인' '명시적인' 그런 의미를 담은게 아닌가 좀더 주관적인 해석을 하고있습니다.

<br>

>ThisBinding : this 식별자가 바라봐야하 할 대상객체
>>좀더 편하게 설명하면 스코프의 개념인데 이안에서 
실행하는 시점에서 EC (Excenution Context) 생성되고 그지점에서 
온갓 일들이 일어납니다.

<br>

>LexicalEnvironment, VariableEnvironment(스냅샷) 내부를 이루는 
environmentRecord,outerEnvironmentReference 는 호이스팅의 요인이다. 원리를 파악해보자
>>environmentRecord
>>>현재 컨텍스트와 관련된 코드들이 복사된다. 이때 함수, 지정된 매계변수 식별자(var)등이 구성이 되어있습니다.
<br>※참고 : window, Global은 내장객체가 아닌 호스트객체로 분류함 
[참고사이트](https://velog.io/@bangina/FE%EB%A9%B4%EC%A0%91%EB%8C%80%EB%B9%84-%ED%98%B8%EC%8A%A4%ED%8A%B8-%EA%B0%9D%EC%B2%B4Host-Objects%EC%99%80-%EB%84%A4%EC%9D%B4%ED%8B%B0%EB%B8%8C-%EA%B0%9D%EC%B2%B4Native-Objects)
<br>
호스트 : os와 브라우저 환경에 따라 달라짐<br>
내장객체, 네이티브객체 : 기본으로 모든 환경에서 동일하게 활용




```
/*호이스팅 예제*/

function a(x){
    console.log(x); //x의 매게값이 출력 
    var x; 
    console.log(x); //x의 매게값이 출력
    var x = 2;
    console.log(x); // 2가 출력이
}
a(1);

function b (){
    console.log(x); // 당연히 여기는 어디 파인드가 호출이 되겠지
    var x = 1;
    console.log(x);
    var x; 
    console.log(x);
    var x = 2;
    console.log(x);
}
b();


//실제 코드가 동작하는 과정
function b (){
    var x;
    var x; 
    var x;
    x = 1;
    console.log(x);
    console.log(x);
    x = 2;
    console.log(x);
}
b();

function c(){
    console.log(c); //undefined
    var c = 'ccc'; // 할당
    console.log(c); // ccc
    console.log(d); // 함수호출 : 호이스팅
    d(); 
    function d(){
        console.log(c);
        console.log(f);
    } // 함수선언
    console.log(d); // 함수호출
    var f = 'fff';
}
c(); 

```

<br>


### ※스냅샷이란?
>특정 시간에 데이터 저장 장치의 상태를별도의 파일이나 이미지로 저장하는 기술로, 스냅샷 기능을 이용하여 데이터를 저장하면 유실된 데이터 복원과 일정 시점의 상태로 데이터를 복원할 수 있습니다.

 ＃[참조사이트1](https://tyle.io/blog/54)
 ＃[참조사이트2](https://choseongho93.tistory.com/189)

```
var a = 3 ; //전역선언

function outer (){
    console.log(a) // 값:3 클로저
    function inner(){
        console.log(a); // 값은 언디파인드 이유는 호이스팅
        var a = 2;
        console.log(this); //여기서는 전역을 호출한다.
        console.log(inner); //여기서는 스콥이 연결된 상태의 inner를 확인할수 있다.
    }
    inner();
    console.log(a) //값:3
}

outer();

console.log(a); // 3 스냅샷
```


----------

<br>

## 함수선언법 종류

>아래와 같이 함수를 선언하는 방법은 천차 만별입니다.
>>하지만 모든 함수 선언이 같은 프로퍼티와 스콥을 가지고 있지 않습니다.
>>> 특히 this 가 다른 화살표 함수가 대표적인 예입니다.

```
function a () {}

var b = function () {}

var c = function d () {}

const e = () = > {}

const f = new a;

a() //ok
b() //ok
c() //ok
d() //err
e() //ok
f() //ok
```
<br>

>함수 선언문과 호이스팅
```
console.log(sum(1,2)); // ok
console.log(multiply(3,4)); //err

function sum(a,b){
    return a + b;
}

var multiply = function(a,b){
    return a * b;
}
```

>위는 아래와 같이 변경된다.
```
var multiply;
var sum = function sum(a,b){
    return a + b;
}

console.log(sum(1,2)); // ok
console.log(multiply(3,4)); //err

multiply = function(a,b){
    return a * b;
}
```

>이렇게 보면 함수 선언식의 위험성 
```
console.log(sum(3,4));

function sum(x,y){
    return x + y;
}

var a = sum(1,2);

console.log(a);

// .... 5000 line after

// 모든 sum은 상하 상관없이 마지막 선언된 sum을 기준으로 실행된다.

function sum(x,y){
    return x + ' + ' + y + ' = ' + (x+y);
}

var c = sum(1,2);


console.log(c);
```

>이렇게 보면 함수 표현식이 상대적으로 안전하다.
```
console.log(sum(3,4));

var sum = function(x,y){
    return x + y;
}

var a = sum(1,2);

console.log(a);

var sum = function (x,y){
    return x + ' + ' + y + ' = ' + (x+y);
}

var c = sum(3,4);

console.log(c);

```

----------

<br>

## 스코프 체인

>오직 전역함수를 제외한 부분에선 함수에서만 스코프가 생깁니다.
>> 자 만약 앞부분에서 실행컨텍스트를 테스트했던부분에서 inner를 찍으면 어떻게 되는가? 콘솔에 스콥을 확인해보자

```
var a = 1;
function outer(){
    function inner(){
        console.log('inner',a); //undefined , 스냅샷으로 값이 방영되지 않습니다.
        var a = 3; 
        console.dir(inner); 
        // 이때 글로벌 a에 접근할수 없음으로 변수의 은닉화이다.
    }
    inner();
    console.log(a);  // 1
    console.log(b);  // undefined
    var b = 5 ;

    inner2() // 호이스팅

    function inner2(){
        var c = 3;
        console.log('inner2',a); //undefined , 스냅샷으로 값이 방영되지 않습니다.
        console.log(c); // 3
    }
}
outer();
console.log(a); // 1
```



# 01.데이터타입

<br>

## 데이터타입

> **서술**
:스크릅트 언어들은 다양한 목적에 비슷한시기에 많은언어가 형성 되어 있다. 이중 웹 서버스크립트로 사옹중인 JAVA,C(ASP,PHP)계열,파이썬,JAVASCIPT등이 있다. 그래도 어느정도 언어의 특성만 파악하면 모두 비슷한 원리와 개념으로 돌아가기에 이번기회에 하나만 깊게 파서 공부해보자

<br>

----------

<br>

## 기본형의 종류 (Primitive Type)
> 값을 담은 주소값을 복사한다.

```
var a = 1
var b = '1'
var c = true
var d = null
var e 

```
----------
<br>

## 참조형변수의 종류 (Reference Type)
> 값을 담긴 묶음을 가르키는 주소값을 복제한다.

```
var obj = new Object();
function a () {}
var obj2 = new a();
var date = new Date();
var arr = new Array();

```
----------
<br>

## 변수선언 과정 

<br>
1.변수할당

```
var a;  

```

2.데이터 할당

```
a = 'abc'; 
```

3.변수와 데이터를 동시에 할당

```
var a = 'abc' 
```
----------
<br>

## 참조형변수의 종류 (Reference Type)
> 할당이 되는 과정을 표로 확인해봅시다!

```
var a = 1
var b = {
    c : 1,
    d : 2,
}
```

| 1003 | 1004 | 1005 |
|---|:---:|---:|
| 이름 : a , 값은 5005|이름 : b, 값은 5005||
                  
| 5002 | 5005 | 5007 |
|---|:---:|---:|
|1|@7103~|2|

| 7103 | 7104 | 7105 |
|---|:---:|---:|
|@5002|@5007||

----------
<br>


## 객체의 가변성
> 아래의 코드를 보면 코드를 복사시 
같은 주소를 바라보는 두 오브젝트의 값은 변경해도 서로 영향을 미친다.

```
var user = {
     name : 'Jaenam',
     gender: 'male'
}

var chageName = function(user,newName){
     var newUser = user;
     newUser.name = newName;
     return newUser;
}

var user2 = chageName(user,'Jang');

if(user !== user2)
    console.log('유저 정보가 바뀌었습니다.'); // 동작하지않음

console.log(user.name, user2.name); //jang , jang
console.log(user.name === user); // ture;

```

<br>

> 가변성 해결을 위한 얕은 복사
>>아래와 같이 얕의 복사의 경우 내부의 참조변수는 새로운 생성아닌 
복사하는 대상과 같은 주소의 변수를 가르킨다.

```
var copyObject = function (target){
    var result = {};
    for (var prop in target){
        result[prop] = target[prop];
    }
    return result;
}

var user = {
    name : 'jang',
    age : 26
}

var user2 = copyObject(user);
user2.name = 'dogcolley';

if(user !== user2)
    console.log('유저 정보가 바뀌었습니다.');

console.log(user.name , user2.name); // jang, dogcolley
console.log(user === user2); // false

```
----------
<br>

## 깊은 복사 
> 복제한 오브젝트들 또한 새롭게 생성해줍니다!
```
var copyObjectDeep = function (target){
    var result = {};
    if(typeof target === 'object' && target !== null){
        for(var prop in target){
            result[prop] = copyObjectDeep(target[prop]);
        }
    }else{
        result = target;
    }
    return result;
}

var user = {
    name : 'jang',
    skill : {
        main1 : 'html',
        main2 : 'js',
        main3 : 'css',
        sub1 : 'php',
        sub2 : 'sql',
        sub3 : 'apache'
    },
    arr : ['1','2','3']
}

var user2 = copyObjectDeep(user);

user2.name = 'dogcolley';
user2.skill.main1 = 'board';
user2.arr[0] = '0';
console.log(user.name === user2.name);
console.log(user === user2);
console.log(user.arr === user2.arr);

```
----------
<br>

## Json을 활용한 간단한 깊은 복사
>JSON을 활용한 깊은 봅사 방법입니다. 추가적으로 이러한 깊은
복사의 경우 JSON문법으로 통신하는 httpRequest로 받는 데이터를 복사할때 유용한 방법입니다.

```
var copyObjectViaJSON = function(target){
    return JSON.parse(JSON.stringify(target));
}

var obj = {
    a: 1,
    b: {
        c: null,
        d: [1,2],
        func1 : function(){
            console.log(3);
        },
        func2 : function(){
            console.log(4);
        }
    }
}

var obj2 = copyObjectViaJSON(obj);

obj2.a = 3;
obj.b.c = 4;
obj.b.d[1] = 3;

console.log(obj); // {a:1, b:{c:null, d:[1,3], func1: f()}, fun2: f()}
console.log(obj2); // {a:3, b:{c:4, d:[1,2], func1: f()}, fun2: f()}

```
----------
<br>

## undefinde와 널의 차이
null의 경우 '값이없다'인 정의입니다.
 undefind는 '값이없는허수'를 정의해줍니다.

<br>

>자동으로 undefined가 부여되는경우
 ```
var a;
console.log(a) //undefined 값을 대입하지않는 변수에 접근시

var obj = {a:1};
console.log(obj.a); // 1
console.log(obj.b); // undefined 존재하지않는 프로퍼티접근
console.log(b) //err TDZ개념

var func = function(){};
var c = func(); // return이 없을경우 undefinde를 반환
console.log(c); // undefined를 반환

 ```

 <br>
 
>배열의 undefined
```
var arr1 = [];
console.log(arr1[0]) // undefinde
arr1.length = 3;
console.log(arr1) // [3 emptY]
var arr2 = new Array(3) 
console.log(arr2) //[3 emptY]
var arr3 = [undefined,undefined,undefined];
console.log(arr3) //[undefined,undefined,undefined]
```

<br>

>빈 요소와 배열의 순회

1. foreach의 경우 빈배열은 반환하지 않는다.
2. map의 경우 NaN과 empty를 반환한다.
3. filter의 경우 undefined와 빈배열을 반환한다.
4. foreacg와 같이 빈배열은 반환하지 않는다.
```
var arr1 = [undefined, 1];
var arr2 = [];
arr2[1] = 1;

arr1.forEach((v,i)=>console.log()); // undefined 0 / 1 1
arr2.forEach((v,i)=>console.log()); // 1 1

arr1.map((v,i)=> {return v + i}); // [NaN, 2]
arr2.map((v,i)=>console.log()); // [empty, 2]

arr1.filter((v)=>{return !v}); // [undefined]
arr2.filter((v)=>{return !v}); // []

arr1.reduce((p,c,i)=>{return p + c + i},''); // undefined01
arr2.reduce((p,c,i)=>{return p + c + i},''); // 11;
```

위와 같은 결론은 undefined '비어있음을 의미하지만' 할당되지않는 경우는 자바스크립트의 정의로 undefined를 출력해주고
실제로 할당한 인덱스가 존재하지않아 출력이 되지 않음
<br>
위와 같이 '비어있음'을 명시하는것이 헷갈리기 때문에 null을 사용해줍니다.
<br>
<br>
>undefined와 null을 비교
```
var n = null;
console.log(typeof n) // object
console.log(n == undefined); // true
console.log(n == null); // true
console.log(n === undefined); // false
console.log(n === null); // true

```

## ES6에 추가된 const와 let의 차이

>var 의 문제점에서 개선을 위해 추가된 변수 선언 방법 아래와 같은 문제점을 개선
0. var 의 호이스팅 문제 선언시 전역변수에 편입되는 현상
```
// var는 function-scope이기 때문에 for문이 끝난다음에 i를 호출하면 값이 출력이 잘 된다.
// 이건 var가 hoisting이 되었기 때문이다.
for(var j=0; j<10; j++) {
  console.log('j', j)
}
console.log('after loop j is ', j) // after loop j is 10

```

1. 중복 재선언을 해도 문제가 되지않는것을 개선함
```
// 이미 만들어진 변수이름으로 재선언했는데 아무런 문제가 발생하지 않는다.
var a = 'test'
var a = 'test2'

// hoisting으로 인해 ReferenceError에러가 안난다.
c = 'test'
var c
```
2. const의 경우 재선언 재할당이 불가능
3. let의 경우 재선언은 불가능하고 재할당은 가능

```
// let
let a = 'test'
let a = 'test2' // Uncaught SyntaxError: Identifier 'a' has already been declared
a = 'test3'     // 가능

// const
const b = 'test'
const b = 'test2' // Uncaught SyntaxError: Identifier 'a' has already been declared
b = 'test3'    // Uncaught TypeError:Assignment to constant variable.
```
4. const의 경우 선언과 동시에 할당도 해줘야합니다.
```
// let은 선언하고 나중에 값을 할당이 가능하지만
let dd
dd = 'test'

// const 선언과 동시에 값을 할당 해야한다.
const aa // Missing initializer in const declaration
```

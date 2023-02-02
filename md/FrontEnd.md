# Frontend-road (프론트앤드 정리)

>프론트앤드로서의 과정을 정리하고 발전해 나가는 저장소입니다.

![프론트앤드 과정  출처: roadmap.sh](./img/frontend.png "프론트앤드 과정")

<br/>
<br/>
<br/>

***


<br/>
<br/>
<br/>

## Internet
> 여러 통신망을 하나로 연결한다는 의미의 Inter-network에서 시작된 말로 전세계 컴퓨터를 하나로 연결하는 '컴퓨터망'을 의미한다.
<br/>
이러한 인터넷은 '클라이언트'와 '서버'로 구성되어 있으며, 'TCP/IP'라는 기본 프로토콜을 통해 제공된다.


<br/>
<br/>


#### ※통신과정 과정

- 1~2단계, 소비자가 입력한 url을 http 프로토콜로 변환해 DNS에 업로드한다.
- 3단계, 업로드한 URL 중 도메인에 해당하는 부분을 뽑아 IP 주소로 변환해 URL과 함께 출력한다.
- 4단계, HTTP 프로토콜을 이용해 HTTP 요청 메세지를 만들어 TCP 프로토콜을 통해 해당 IP주소의 컴퓨터에 전달한다.
- 5~6단계, HTTP 요청 메세지를 받은 HTTP 프로토콜이, 이를 이용해 URL 주소를 웹서버에 전달하고, 웹서버에서 URL과 일치하는 데이터를 출력한다.
- 7단계, 받은 HTTP 메세지를 TCP 프로토콜을 통해 원 컴퓨터로 전송하고 도착한 HTTP 메세지를 HTTP 프로토콜을 이용해 웹페이지 데이터로 변환한다.

※Protocol 이란? : 컴퓨터와 컴퓨터 사이에 데이터의 표현법,오류검출법등을 정하는 통신규약!

![프론트앤드 과정  출처: roadmap.sh](./img/http,tcp.png "프론트앤드 과정")
※출처 [hwewon_park "인터넷이란" 참고](https://velog.io/@hyewon_park/%EC%9D%B8%ED%84%B0%EB%84%B7%EC%9D%B4%EB%9E%80)

<br/>
<br/>

***

<br/>

### How does the internet work?
> 컴퓨터와 컴퓨터간의 통신입니다. 모든 컴퓨터를 서로 연결할 수 없으니 중앙 네트워크로 관리해준다.<br/>
(10 개의 컴퓨터면)45개의 연결 케이블이 필요하지만 이걸 하나의 네트워크 선으로 연결하는것으로 해결한다.<br/>이러한 중앙 네트워크는 서로 다른 네트워크에 연결 할 수 있으며 이것을 또 관리해주는 네트워크 속 네트워크가 존재한다! <br/> 그렇다면 각각의 네트워크는 어떠할까? 먼곳에 있거나 다른 네트워크를 ISP ( 네트워크를 인터넷 서비스)에 연결되어 전달 하게 된다! 

※출처 [MDN web Docs '인터넷은 어떻게 동작하는가?'](https://developer.mozilla.org/ko/docs/Learn/Common_questions/How_does_the_Internet_work)

<br/>

***

<br/>

### Wath is HTTP (HyperText Transfer Protocol)?
> HyperText Transfer Protocol 정보 이동히 가능한 텍스트를 프로토콜로 통신한다!<br/>
HTML, CSS , JS , API 등으로 파일 형식으로 전달 된다!<br/>
Client <=> Proxy <=> Proxy <=> Server 구성을 가지고 있습니다. 클라이언트의 프록시서버는 웹브라우저 , 웹서버의 프록시서버는 직접 서버에서 제공하지 않아도 다른 내부의 서버에 연결해주는 역활을 말한다.<br/>


※자신을 통해서 다른 네트워크 서비스에 간접적으로 접속할 수 있게 해 주는 컴퓨터 시스템이나 응용 프로그램을 가리킨다. 

<br/>

***

<br/>

### Browers and how they work?
>Chrome, Internet Explorer, Firefox, Safari 및 Opera등이 있다.<br/>
Window에서 제공하는 Internet Explorer나 IOS 에서 제공하는 Safari는 독자적인 프로그램을 가지고 있지만
마이크로 소프트 엣지, 이외 브라우저는 크로미움이라는 Google의 V8프로젝트를 기반으로하는 오픈소스 브라우저를 베이스로 만들어져 있다!

>브라우저의 역활은 다양하다. Dom을 베이스로한 모든 기능 JS와 통신 확인 기록 등 다양한 기능을 제공한다.
그래서 브라우저에 대한 지식만 있다면 다양한 웹서비스를 일상 및 실전에서 사용할 수 있다.

>통신은 HTTP의 기본통신을 따르며 브라우저마다 다양한 UI와 기능을 제공한다. 기본적으로 HTML의 DOM구조를 해석해서 출력시키며 CSS,JS해석하고 실행시킨다. 그리고 브라우저 자체에서 데이터를 저장하는데 COOKIE 및 LOCAL SESSTION이 대표적이다.

<br/>

***

<br/>

### DNS and how it work?
>위키백과에서는 DNS를 이렇게 설명하고 있다.

>도메인 네임 시스템(Domain Name System, DNS)은 호스트의 도메인 이름을 호스트의 네트워크 주소로 바꾸거나 그 반대의 변환을 수행할 수 있도록 하기 위해 개발되었다.

<br/>

***

<br/>

### What is Domain Name?
> 호스트명 (도메인 레지스트리 : NIC에 저장되어있는 ) 등록된 이름을 의미합니다.<br/>
일반 최상위 도메인(gTLD) : .com, .org, net 등이 포함되며 대부분 국가와 상관없이 등록할 수 있기때문에
국제 도메인이라고 불린다. <br>
국가 코드 최상위 도메인(ccTLD) : ISO 3166-1에 의하여 이름이 정되고 각국의 NIC에서 관리되는 국가별 도메인이다. <br>
기반 최상위 도메인(iTLD) : 인터넷의 하부 구조를 위하여 사용되는 특수한 도메인이다. 유일하게 .arpa가 속하지만, 루트 DNS의 vrsn-end-of-zone-marker-dummy-record.root 항목도 여기에 속한다고 볼 수도 있다.

<br/>

***

<br/>

### what is hosting?
> 개인또는 단체가 제공하는 서버입니다. 웹호스팅은 월드 와이드 웹을 통해 웹사이트에서 제공하는 서비스를 말합니다.<br/>
> 종료로는 아래와 같다.

- 무료 웹 호스팅 서비스
- 공유 웹 호스팅 서비스
- 가상 사설 서버
- 클라우스 호스팅
- 파일 호스팅
- 이미지 호스팅
- 비디오 호스팅
- 블로그 호스팅
- 쇼핑 카트 호스팅

>등등의 목적과 용도에 맞는 호스팅을 제공하며 웹개발자는 해당 호스팅 서버의 구축 및 관리를 맡아 한다. <br/>
프론트의 호스팅은 직접 웹 서비스를 제공하는 서버를 제공하고 <br/>
백앤드의 경우 데이터를 제공해주는 API서버를 제공한다.


<br/>

***

<br/>
<br/>
<br/>

## HTML 
>HT(HyperText) : 문서와 문서가 링크로 연결된 언어 <br/>
M(Markup)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: 태그로 이루워져 있다. <br/>L(Language)&nbsp;&nbsp;&nbsp;&nbsp;: 언어

<br/>
<br/>

#### 구조 
```
<!doctype html>
<html>
    <head>
        <title>Hello HTML</tile>
    </head>
    <body>
        <p value="data" >Hello Word!</p>
    </body>
</html>
```
>head는 눈에보이지 않는 정보 body는 눈에보이는 정보를 담고있다.<br>
각테그엔 p 안의 value와 같이 속성을 담고 있으며 해당 속성에 따라 다양한 기능및 데이터를 가공하여 제어한다.

<br/>
<br/>

***

<br/>

### Writing Semantic HTML?
> HTML5에 추가된 태그들 기능에 차이가 뒀던 기존 마크업 태그와 달린 태그 자체에 컨텐츠의 의미를 담은 마크업방식이다.


| 태그 | 설명 |
|------------------|:------------------|
| `<!-- -->` |주석(comment)을 정의함. | 
| `<!DOCTYPE>` | 해당 문서(document)의 타입을 정의함. | 
| `<a>` |다른 콘텐츠와 연결되는 하이퍼링크(hyperlink)를 정의함.| 
| `<abbr>` |축약형(abbreviation)이나 머리글자로만 된 단어(acronym)를 정의함.| 
| `<address>` |문서나 글의 저자 또는 회사와 연락할 수 있는 정보를 명시함.| 
| `<area>` | 이미지 맵(image-map)에서 하이퍼링크가 연결될 영역을 정의함.| 
| `<article>` |[HTML5]해당 문서나 페이지 또는 사이트와는 완전히 독립적으로 구성할 수 있는 요소를 정의함.| 
| `<aside>` |[HTML5]페이지의 다른 콘텐츠들과 약간의 연관성을 가지고 있지만 해당 콘텐츠들로부터 분리시킬 수 있는 콘텐츠로 구성된 페이지 영역을 정의함.| 
| `<audio>` |[HTML5]음악이나 오디오 스트림과 같은 사운드를 정의함.| 
| `<body>` |해당 문서의 콘텐츠 영역을 정의함.| 
| `<br>` |행 바꿈(line-break)을 정의함.| 
| `<button>` |클릭할 수 있는 버튼을 정의함.| 
| `<canvas>` |[html5]자바스크립트와 같은 스크립트를 이용하여 그래픽 콘텐츠를 그릴 때 사용함.| 
| `<caption>` |테이블의 캡션(caption)을 정의함.| 
| `<cite>` |예술 작품과 같은 창작물의 제목을 정의함.| 
| `<code>` |컴퓨터 코드(code)의 일부분을 나타냄.| 
| `<col>` |요소에 속하는 각 열(column)의 속성을 정의함.| 
| `<colgroup>` |테이블에서 서식 지정을 위해 하나 이상의 열을 그룹으로 묶을 때 사용함.| 
| `<dd>` |용어와 그에 대한 설명을 리스트 형식으로 보여주는 <dl> 요소에서 설명(description) 부분을 정의함.| 
| `<div>` |HTML 문서에서 특정 영역이나 구획을 정의함.| 
| `<dl>` |용어와 그에 대한 설명을 리스트 형식으로 정의함.| 
| `<dt>` |용어와 그에 대한 설명을 리스트 형식으로 보여주는 <dl> 요소에서 용어(term) 부분을 정의함.| 
| `<em>` |강조된 텍스트를 표현함.| 
| `<fieldset>` |요소에서 연관된 요소들을 하나의 그룹으로 묶을 때 사용함.| 
| `<figcaption>` |<fieldset> 요소의 캡션(caption)을 정의함.| 
| `<figure>` |[HTML5]삽화나 다이어그램, 사진 등과 같이 문서의 주요 흐름과는 독립적인 콘텐츠를 정의함.| 
| `<footer>` |[HTML5]문서나 특정 섹션의 푸터(footer)를 정의함.| 
| `<form>` |사용자로부터 입력을 받을 수 있는 HTLM 입력 폼(form)을 정의함.| 
| `<h1> ~ <h6>` |HTML 문서에서 제목(headings)을 정의함.| 
| `<head>` |해당 문서에 대한 정보인 메타데이터(metadata)의 집합을 정의함.| 
| `<header>` |[HTML5]문서나 특정 섹션의 헤더(header)를 정의함.| 
| `<hr>` |콘텐츠 내용에서 주제가 바뀔 때 사용할 수 있는 수평 가로선을 정의함.| 
| `<html>` |HTML 문서의 루트 요소(root element)를 정의함.| 
| `<i>` |기본 텍스트와는 다른 분위기나 음성을 위한 텍스트 영역을 정의함.| 
| `<iframe>` |인라인 프레임(inline frame)을 정의함.| 
| `<img>` |이미지(image)를 정의함.| 
| `<input>` |사용자로부터 입력을 받을 수 있는 입력 필드(input filed)를 정의함.| 
| `<label>` |사용자 인터페이스(UI) 요소의 라벨(label)을 정의함.| 
| `<legend>` | <fieldset> 요소의 캡션(caption)을 정의함.| 
| `<li>` |HTML 리스트(list)에 포함되는 아이템(item)을 정의함. | 
| `<link>` | 해당 문서와 외부 소스(external resource) 사이의 관계를 정의함.| 
| `<main>` | [HTML5] 해당 문서의 <body> 요소의 주 콘텐츠(main content)를 정의함.| 
| `<map>` |클라이언트 사이드 이미지맵(client-side image-map)을 정의함.| 
| `<mark>` | [HTML5]형광펜으로 칠한 것처럼 하이라이트된(highlighted) 텍스트를 정의함.| 
| `<meta>` | 해당 문서에 대한 정보인 메타데이터(metadata)를 정의함. | 
| `<nav>` | [HTML5]다른 페이지 또는 현재 페이지의 다른 부분과 연결되는 네비게이션 링크(navigation links)들의 집합을 정의함. | 
| `<noscript>` |클라이언트 사이드 스크립트(client-side scripts)를 사용하지 않도록 설정했거나, 스크립트를 지원하지 않는 브라우저를 위한 별도의 콘텐츠를 정의함.| 
| `<ol>` |순서가 있는 HTML 리스트(list)를 정의함.| 
| `<option>` | 옵션 메뉴를 제공하는 드롭다운 리스트(drop-down list)에서 사용되는 하나의 옵션을 정의함.| 
| `<p>` |문단(paragraph)을 정의함. | 
| `<picture>` |[HTML5]<img> 요소의 다중 이미지 리소스(multiple image resources)를 위한 컨테이너를 정의함| 
| `<q>` |짧은 인용구를 정의함.| 
| `<script>` |자바스크립트와 같은 클라이언트 사이드 스크립트(client-side scripts)를 정의함.| 
| `<section>` | [HTML5]HTML 문서에 포함된 독립적인 섹션(section)을 정의함.| 
| `<select>` |옵션 메뉴를 제공하는 드롭다운 리스트(drop-down list)를 정의함.| 
| `<source>` |<audio> 요소나 <video> 요소에서 사용할 수 있는 다중 미디어 자원(multiple media resources)을 정의함.| 
| `<span>` |HTML 문서에서 인라인 요소(inline-element)들을 하나로 묶을 때 사용함.| 
| `<strong>` |해당 콘텐츠의 중요성이나 심각함, 긴급함 등을 강조함.| 
| `<style>` |해당 HTML 문서의 스타일 정보를 정의함.| 
| `<svg>` |SVG 그래픽을 위한 컨테이너를 정의함.| 
| `<table>` |데이터를 포함하는 셀(cell)들의 행과 열로 구성된 2차원 테이블을 정의함.| 
| `<tbody>` |테이블에서 내용 콘텐츠(body content)들을 하나의 그룹으로 묶을 때 사용함.| 
| `<td>` |테이블에서 하나의 셀(cell)을 정의함.| 
| `<template>` |[HTML5]추가되거나 복사될 수 있는 HTML 요소들을 정의함.| 
| `<textarea>` |사용자가 여러 줄의 텍스트를 입력할 수 있는 텍스트 입력 영역을 정의함.| 
| `<tfoot>` |테이블에서 푸터 콘텐츠(footer content)들을 하나의 그룹으로 묶을 때 사용함.| 
| `<th>` |테이블에서 제목이 되는 헤더 셀(header cell)들을 정의함.| 
| `<thead>` |테이블에서 헤더 콘텐츠(header content)들을 하나의 그룹으로 묶을 때 사용함.| 
| `<time>` | [HTML5]사람이 읽을 수 있는(human-readable) 형태의 날짜와 시간 데이터를 정의함.| 
| `<title>` |해당 문서의 제목(title)을 정의함.| 
| `<tr>` |테이블에서 셀들로 이루어진 하나의 행(row)을 정의함.| 
| `<track>` |[HTML5]<audio>나 <video> 요소와 같은 미디어 요소를 위한 텍스트 트랙(track)을 정의함.| 
| `<u>` |철자가 틀린 단어나 중국어의 고유 명사처럼 문체상 일반적인 텍스트와는 달라야만 하는 텍스트를 표현함| 
| `<ul>` |순서가 없는 HTML 리스트(list)를 정의함.| 
| `<video>` |[HTML5]무비 클립(movie clip)이나 비디오 스트림(video stream)과 같은 비디오를 정의함. | 


<br/>

***

<br/>


### Forms and Valdations?
> FROM 태그를 사용해서 유효성을 검사하는 부분이다.

['참고사이트'](https://velog.io/@ssoon_d/2.-Forms-and-Validations)




<br/>

***

<br/>

### Conventions and Best Practices?
- 컨벤션은 규칙, 규약 이라는 뜻으로 여러명이 미리 약속 된 변수 네이밍 규칙 등, 혹은 일관된 틀을 만드는 행위를 뜻합니다.
- 일관되고 깔끔한 HTML 코드를 사용하면 다른 사람들이 쉽게 코드를 읽고 이해할 수 있습니다.

['참고사이트'](https://velog.io/@brviolet/%EB%A1%9C%EB%93%9C%EB%A7%B5-%EA%B8%B8%EB%A7%8C-%EA%B1%B8%EC%96%B4%EC%9A%94-HTML-Conventions-and-Best-Practice)


<br/>

***

<br/>

### Accesslibility?
> 접근성이라는것은 모든 사람들a이 (신체적 장애나, 연령대에 상관없이) 모두 평등한 정보를 제공받는 것이다. <br>
> 한국의 경우 웹 '한국형 웹콘텐츠 접근성 지침 2.1'에 따르는 [웹접근성평가센터](http://www.wa.or.kr/)등과 같은 인증공인기관에서 인증 마크를 발급하는데 공공기관이나 국가에서 요하는 경우 인증을 한다.
> 



<br/>

***

<br/>

### SEO Basics?
> 검색엔진 최적화란?<br>
> META태그를 이용해서 정보를 제공한다. 그럼 검색엔진사이트에서 데이터를 수집하는데 <br>
> 고유의 key값이나 meta데이터 값이 모두 다르다. 공통적으로 TITLE이나 CONTENT같은 데이터를 수집하며 
> 이미지나 파비콘 등등 다양한 정보를 수집해서 노출 시킨다.

<br/>

***

<br/>
<br/>


## CSS 
>(Cascading Style Sheet) 이란 웹 콘텐츠의 스타일 지정하는 코드입니다. <br/>
태그를 지정하고 해당테그에 스타일을 지정한다는것만 안다면 어렵지 않게 배울수 있다.

<br/>

### Learm the basics?
> 우리가 생각하는 프로그래밍 언어가 아니라 웹에 지정되어있는 스타일을 적용 시킬때 사용한다.

### 외부에서의 스타일
```
<head>
    <link href="style.css" rel="stylesheet" />
</head>
```

### 내부에서의 스타일
>body나 head에 해당 스타일태그를 입력하여 직접 사용가능하다.
```
<head or body>
    <style>
        body{width:100%;height:100%}
    </style>
</head or body>
```

### 사용방법
>css의 숙지할 점이 너무 많익 떄문에 정리가 잘되어있는

※['HEROPY님의 갓갓 정리문서'](https://heropy.blog/,'태그')를 참고하자!


```
    /*
        기본적으로 태그 속성은 부모의 속성을 상속 받는 경우가 많다.
        -아닌 경우는 별도의css를 주입 한경우 
        -아닌 경우는 태그의 고유속성이 적용 되어있을경우
    */

    /*
        아닌 경우 div에 width:100%를 넣어줘도 태그의 기본 속성인
        display는 div는 block, span은 inline 이기 때문에
        inline태그의 특징상 width의 값을 인식 하지 못한다.
    */ 
    
    <div>
        <span></span>
    </div>
    <style>
        div{width:100%} 
    </style>

    /*태그지정 {속성지정}*/

    /* body라는 태그에 width(넓이)를 100% 지정해준다. */    
    body {
        width:100%
    }

    /* body의 직접 자식인 모든 태그에 속성을 넣어준다. */
    body > *  {
        width:100%
    }

    /* body안의 모든 div태그에게 속성을 주입한다. */
    body div{
        width:100%
    }
    

    /* body안의 첫번쨰 div에게 적용시킨다.*/
    body div:first-child{
        width:100%
    }

    /* body안의 마지막 div에게 적용시킨다.*/
    body div:last-child{
        width:100%
    }

    /* 
        ※다양한 선택자 지정태그
        body안의 '지정' div에 적용시킨다. 
        even    : 짝수번쨰의  div에게만
        odd     : 홀수번쨰의  div에게만
        '숫자'  : '숫자'번째
        숫자n   : n번째요소의 div에게만  
        n+숫자  : 숫자 이후의 모든 div에게만
        -n+숫자 : 앞에서 세 개의 요소를 나타낸다. 
        div:nth-child(n+8):nth-child(-n+15)
        : 8부터~15까지 숫자에서 숫자 까지의 div태그에게만
    */

    body div:nth-child(지정){
        width:100%
    }

    /* 
        태그의 ID와 Class를 지정해서 주는 속성 
        단 ID경우에는 한 html문서에 1개만
        class는 여러개 인 것을 알고 있으면 된다!
    */
    #id1    {width:100%}
    .class1 {width:100%}

```


### SCSS / SASS / LESS
>변수, 함수, 연산, 호출, 프로그램언어가아닌 CSS언어를 고도화 시켜 가능하게 만든후
CSS파일로 컴파일 시켜준다. <br/> 자세한 설명과 방법은 아래의 링크를 참고하도록 하자!

※['HEROPY님의 갓갓 정리문서'](https://heropy.blog/2018/01/31/sass/,'태그')를 참고하자!


<br/>
<br/>

***

<br/>

### Making Layouts
> 포토샵의 LayOut구조 또는 계층,트리 구조라고 생각하면 된다.

- 기본적인 body안의 구조에 제목 상단 / 컨텐츠 / 하단 이런식으로 계층 구조를 이룬다.
- 이러한 기본 적인 구조를 마크업 한뒤 CSS를 입힌다.
- 해당형식은 고정이 아니라 비슷한 구조로 본인이 원하는 구조를 지키면 된다.)
- markup 정규식과 웹접근성등을 고려하면 참고해야하는 상항은 많지만 해당사항은 위의 html파트에서 참고해서 공부하면 된다!
- 자 이후엔 display , absolute 라는 css의 가장큰 layout 스타일 부분을 공부하면 된다!


```
<!-- 기본적인 마크업 구조 예시 -->
<body>
    <h1>제목</h1>
    
    <header>
        <nav>
        
        </nav>
    </header>
    
    <aside>
    
    </aside>

    <sestion>
        <h2>
        
        </h2>

        <div>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>

    </sestion>
    
    <footer>
        <address>
        
        </address>
    </footer>
</body>

```

### 포지션과 디스플레이
> css의 영역에 관련된 속성입니다. 크게 이렇게 두개를 사용합니다! <br/>
> Display는 각각의 영역이 존재하여 서로의 영역에 영향을 미칩니다.<br/>
> Position의 경우는 서로의 영역과는 상관없이 상관없이 배치해서 겹치거나 멀리 떨어져 있기도 합니다.<br/>

※[Display 관한설명링크](https://blog.naver.com/iyakiggun/100162787755,'태그')를 참고하자!
`<br/>
※[position 관한설명링크](https://developer.mozilla.org/ko/docs/Web/CSS/position,'태그')를 참고하자!



<br/>

***

<br/>

### Rcsponsive desing and Media Querics
> CSS의 기능으로 화면에 따라 가능 제어가 가능하다.

※['미디어 쿼리 '](https://developer.mozilla.org/ko/docs/Learn/CSS/CSS_layout/Media_queries,'태그')를 참고하자!













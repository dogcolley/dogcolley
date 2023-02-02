// BASIC EXAMPLE
function outer(){
  const cat = "meow";
  function inner(){ // 함수 내부에 함수를 작성하면, 그게 바로 클로저를 생성한 것!
    const say = "hello ";
    console.log(say+cat); 
  }
  return inner();
}
outer();

// SECOND EXAMPLE
function logger(msg){
  const date = new Date();
  return {
    log(log){
      console.log(`[TIME: ${date} ]${msg} ${log}`);
    },
    error(err){
      console.log(`[TIME: ${date} ]${msg} ${err}`);
    }
  }
}

const log = logger('log message: ');
log.log('로그');
log.error('에러');


/**
 * 참고 링크
 * https://poiemaweb.com/js-closure
 * https://medium.com/@khwsc1/%EB%B2%88%EC%97%AD-%EC%9E%90%EB%B0%94%EC%8A%A4%ED%81%AC%EB%A6%BD%ED%8A%B8-%EC%8A%A4%EC%BD%94%ED%94%84%EC%99%80-%ED%81%B4%EB%A1%9C%EC%A0%80-javascript-scope-and-closures-8d402c976d19
 */
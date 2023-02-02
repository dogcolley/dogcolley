process.stdin.setEncoding('utf8')
let input;
process.stdin.on('readable',()=>{
    input = process.stdin.read();
    if (input !== null) {
        var arr = input.split(' '),
          a = parseInt(arr[0]),
          b = parseInt(arr[1]);
 
        console.log(a/b);
     }
})
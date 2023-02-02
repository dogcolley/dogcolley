function solution(lottos, win_nums) {
    let answer = []
    let cnt = 0
    let num = 0

    lottos.forEach(value => {
        if(value !== 0)
            win_nums.indexOf(value) > -1 ? cnt++ : 0
        else
            num++
        
    })

    answer.push(7-(cnt+num == 0 ? 1 : cnt+num))
    answer.push(7-(cnt == 0 ? 1 : cnt))
    
    return answer
}

a = solution([1,2,3,4,5,6],[7,8,9,10,11,12])

console.log(a)
import java.util.Arrays;

public class lesson08 {

	public static void main(String[] args) {
		// 2차원 배열
		// 버블 솔트
		/* 알고리즘
		 * 1기가 = 10억번 연산 초당
		 * 백준문제 = 1기가 10억번 
		 * N^2
		 * n ln n //양이 많을때
		 * n ln * n //양이 많을때 
		 * 
		 * */
		
		int arr[] = { 9, 3, 1, 2, 4, 7, 8, };
		
		echoFor(arr);
		
		int num =0;
		/*
		//1. 가장기본적인 버블 형식의 정렬 방식 
		// n * (n-1) 
		for(int i = 0 ; i < arr.length-1; i++){
			for(int k = 0 ; k < (arr.length - i -1 ) ; k++){ // i를 빼면 정수합공식
				if(arr[k] > arr[k+1]) {
					swap(arr, k , k+1);
				}
				System.out.print("정렬");
				//echoFor(arr);
				num++;
			}
		}
		*/
		
		
		/*2. do while을 이용한 탈출 예제
		boolean pass = true;
		
		do{
			for(int k = 0 ; k < arr.length-1 ; k++){ // i를 빼면 정수합공식
				if(arr[k] > arr[k+1]) {
					swap(arr, k , k+1);
				}else {
					pass = false;
				}
				System.out.println(pass);
				//System.out.print("정렬");
				echoFor(arr);
				num++;
			}
		}while(pass);
		*/
		
		//3. 내장 함수를 이용한 정렬방법
		//Arrays.sort(arr);
		

		//과제1 버블소트 함수만들기 내림차 배열만 넣으면 bubbleSort
		bubbleSort(arr,"desc");
		echoFor(arr);
		bubbleSort(arr,"asc");
		echoFor(arr);
		System.out.print(lesson09.a);
	}


	
	public static void swap (int[] arr, int a , int b) {
		int tmp = 	arr[a];
		arr[a] = arr[b];
		arr[b] = tmp;
	}
	
	public static void echoFor (int[] arr) {
		System.out.print("배열출력:");
		
		for(int i =0;i< arr.length;i++ ) {
			System.out.print(arr[i]);
		}
		System.out.println("===============");
	}
	
	public static void bubbleSort (int[] arr, String mode) {
		
		for(int i = 0 ; i < arr.length-1; i++){
			for(int k = 0 ; k < (arr.length - i -1 ) ; k++){ // i를 빼면 정수합공식
				if(mode == "desc" && arr[k] > arr[k+1]) {
					swap(arr, k , k+1);
				}else if(mode == "asc" && arr[k] < arr[k+1]){
					swap(arr, k , k+1);
				}
			}
		}
	}
}

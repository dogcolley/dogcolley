import java.util.Arrays;

public class lesson08 {

	public static void main(String[] args) {
		// 2���� �迭
		// ���� ��Ʈ
		/* �˰���
		 * 1�Ⱑ = 10��� ���� �ʴ�
		 * ���ع��� = 1�Ⱑ 10��� 
		 * N^2
		 * n ln n //���� ������
		 * n ln * n //���� ������ 
		 * 
		 * */
		
		int arr[] = { 9, 3, 1, 2, 4, 7, 8, };
		
		echoFor(arr);
		
		int num =0;
		/*
		//1. ����⺻���� ���� ������ ���� ��� 
		// n * (n-1) 
		for(int i = 0 ; i < arr.length-1; i++){
			for(int k = 0 ; k < (arr.length - i -1 ) ; k++){ // i�� ���� �����հ���
				if(arr[k] > arr[k+1]) {
					swap(arr, k , k+1);
				}
				System.out.print("����");
				//echoFor(arr);
				num++;
			}
		}
		*/
		
		
		/*2. do while�� �̿��� Ż�� ����
		boolean pass = true;
		
		do{
			for(int k = 0 ; k < arr.length-1 ; k++){ // i�� ���� �����հ���
				if(arr[k] > arr[k+1]) {
					swap(arr, k , k+1);
				}else {
					pass = false;
				}
				System.out.println(pass);
				//System.out.print("����");
				echoFor(arr);
				num++;
			}
		}while(pass);
		*/
		
		//3. ���� �Լ��� �̿��� ���Ĺ��
		//Arrays.sort(arr);
		

		//����1 �����Ʈ �Լ������ ������ �迭�� ������ bubbleSort
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
		System.out.print("�迭���:");
		
		for(int i =0;i< arr.length;i++ ) {
			System.out.print(arr[i]);
		}
		System.out.println("===============");
	}
	
	public static void bubbleSort (int[] arr, String mode) {
		
		for(int i = 0 ; i < arr.length-1; i++){
			for(int k = 0 ; k < (arr.length - i -1 ) ; k++){ // i�� ���� �����հ���
				if(mode == "desc" && arr[k] > arr[k+1]) {
					swap(arr, k , k+1);
				}else if(mode == "asc" && arr[k] < arr[k+1]){
					swap(arr, k , k+1);
				}
			}
		}
	}
}

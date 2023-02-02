import requests
from bs4 import BeautifulSoup
response = requests.get('http://www.howtoweddingexpo.net/')
soup = BeautifulSoup(response.text, 'html.parser')
for p in soup.select('img'):
    print(p)
    
for link in soup.select('a'):
    print(link.get('href')) # a태그의 href를 전부 찾기
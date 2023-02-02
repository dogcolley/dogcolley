import requests
import urllib.request
import re
from bs4 import BeautifulSoup

URL = 'https://www.google.com/search?q=%ED%8C%8C%EC%9D%B4%EC%8D%AC&hl=ko&sxsrf=ACYBGNRHrs8YKA3qnOcN6X-WNZQKLppxkQ:1578315048867&source=lnms&tbm=isch&sa=X&ved=2ahUKEwiM7tLege_mAhVHyIsBHfuCA8IQ_AUoAXoECBEQAw&biw=574&bih=878'
headers = {'Content-Type': 'application/json; charset=utf-8'}
res = requests.get(URL, headers=headers)

soup = BeautifulSoup(res.text, 'html.parser')

i = 0

for img in soup.find_all("img"):

    if img.get('src') is None:
        continue
    if img.get('data-src') is None:
        continue

    a = img.get("src").find("http")
    b = img.get("data-src").find("http")

    if a == -1:
        i = i + 1
        img_name = str(i) + ".jpg"
        c = "http:" + img.get("src")
        print(img_name)
        urllib.request.urlretrieve(c, "./img/" + img_name)
    else:
        i = i + 1
        img_name = str(i) + ".jpg"
        print(img_name)
        urllib.request.urlretrieve(img.get('src')[a:], "./img/" + img_name)
    if b == -1:
        i = i + 1
        img_name = str(i) + ".jpg"
        d = "http:" + img.get("data-src")
        print(img_name)
        urllib.request.urlretrieve(d, "./img/" + img_name)
    else:
        i = i + 1
        img_name = str(i) + ".jpg"
        print(img_name)
        urllib.request.urlretrieve(img.get('data-src')[b:], "./img/" + img_name)
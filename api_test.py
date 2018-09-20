import requests
import hmac
import hashlib
import datetime
import json
import time

key = "xxxx"
redirect_url = "https://www.google.com"
partnerid = xxxx
shopid = xxxx

bs = key + redirect_url
m = hashlib.sha256()
m.update(bs.encode())
sig = m.hexdigest()

base_auth_url = "https://partner.shopeemobile.com/api/v1/shop/auth_partner?id={0}&token={1}&redirect={2}"
auth_url = base_auth_url.format(str(partner_id), sig, redirect_url)


now_time = datetime.datetime.utcnow() + datetime.timedelta(hours=8)
now_time = int(now_time.timestamp())

order_url = "https://partner.shopeemobile.com/api/v1/orders/get"

s = requests.Session()

payload = {
    "order_status": "READY_TO_SHIP",
    "partner_id": partnerid,
    "shopid": shopid,
    "timestamp": now_time
}

bs = order_url + "|" + json.dumps(payload)
dig = hmac.new(key, msg=bs.encode(),
               digestmod=hashlib.sha256).hexdigest()

auth_header = {
    "Authorization": dig
}

res = requests.post(order_url, data=json.dumps(payload), headers=auth_header)
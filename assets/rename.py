
import os
import shutil

mp = ["tvm","hhp", "tat", "qvt", "qd", "phc", "cl", "ls", "thaihao", "hq", "thienhoa", "thanhoang", "ac", "kc", "tl", "pq", "qv","ha"]

# for i in mp:
#     shutil.copyfile("class/char_backgrounds/tvm.jpg", "class/char_backgrounds/{}.jpg".format(i))



for index, item in enumerate(mp):
    str = """#chara0{} .chara_img **
    background: url(/assets/images/class/charsv2/{}.png) no-repeat 60% center;
    background-size: contain;
  **""".format(index+1,item)
    print(str)




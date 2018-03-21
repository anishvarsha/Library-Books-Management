r=open('books.csv','r')
f = open('isbntitle.csv','w')


k=r.readlines()
for i in range(0,len(k)):
    s=k[i].split('\t')
    f.write(s[1]+','+s[2]+'\n')


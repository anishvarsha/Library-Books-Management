r=open('books.csv','r')
f = open('isbnauthor.csv','w')
e = open('split_author.csv','w')

k=r.readlines()
for i in range(0,len(k)):
    s=k[i].split('\t')
    f.write(s[1]+','+s[3]+'\n')

g=open('isbnauthor.csv','r')
j=g.readlines()
for i in range(0,len(j)):
    s=j[i].split(',')
    for p in range(1,len(s)):
            e.write(s[0]+','+s[p]+'\n')

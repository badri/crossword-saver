#!/usr/bin/env python
import re
import sys
from bs4 import BeautifulSoup

if len(sys.argv) < 2:
  print 'Usage: parse.py cryptic-25330.html'
  sys.exit()

clue=re.compile('(?P<number>[0-9]+)[\\.\s]*(?P<clue>[0-9A-Za-z,:;\'"\\.\\?!\\-\\(\\) ]+)\((?P<length>[0-9,-]+)\)')
punctuations = re.compile("(,|-)")

def sanitize(l):
    l = l.replace(u'\u2019', u'\'').replace(u'\u2014', u'--').replace(u'\u2026', u'...').replace(u'\u0022', u'"').replace(u'\u201c', u'"').replace(u'\u201d', u'"')
    return l

def get_length(l): return eval(punctuations.sub("+",l))

s = BeautifulSoup(open(sys.argv[1]).read())
metadata = s.title.get_text().split('|')[-1].split('-')
title = metadata[0].strip()
date_appeared = metadata[1].strip()
print title
print date_appeared
grid = {}
rows = s.find('table',attrs={'id':'crossword-Grid'}).tbody.find_all('tr')

for i,row in enumerate(rows):  
  cols = row.find_all('td')
  for j,col in enumerate(cols):
    number = 0
    letter = ''
    letter_markup = col.find('div', attrs={'class':'crossword-Letter'})
    if letter_markup: letter = letter_markup.get_text()
    number_markup = col.find('span', attrs={'class':'crossword-Number'})
    if number_markup: number = number_markup.get_text()
    grid[15*i+j+1] = (number,letter)
#print grid

across = s.select('#clueContainer table')[0].tbody.find_all('tr')[1:]
down = s.select('#clueContainer table')[1].tbody.find_all('tr')[1:]


for c in across:
  m=clue.match(sanitize(c.get_text()))
  clue_number = m.group('number')
  clue_text = m.group('clue')
  clue_length = m.group('length')
  l = int(get_length(clue_length))
  box = [(x,grid[x]) for x in grid if grid[x][0]==clue_number].pop()[0]
  answer = ''.join([grid[box+x][1] for x in range(l)])
  print clue_number, clue_text, clue_length, answer, box

for c in down:
  m=clue.match(sanitize(c.get_text()))
  clue_number = m.group('number')
  clue_text = m.group('clue')
  clue_length = m.group('length')
  l = int(get_length(clue_length))
  box = [(x,grid[x]) for x in grid if grid[x][0]==clue_number].pop()[0]
  answer = ''.join([grid[box+15*x][1] for x in range(l)])
  print clue_number, clue_text, clue_length, answer, box

sq = ''.join(map(lambda x: '1' if grid[x][1] else '0',grid))
print sq


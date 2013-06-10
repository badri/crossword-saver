#!/usr/bin/env python
import re
import sys
import time
from bs4 import BeautifulSoup

clue_regex = re.compile('(?P<number>[0-9]+)[\\.\s]*(?P<clue>[0-9A-Za-z,:;\'"\\.\\?!\\-\\(\\) ]+)\((?P<length>[0-9,-]+)\)')
punctuations = re.compile("(,|-)")

class TimesParser:
  '''Parses a crossword puzzle from the times page and stores it in xword format'''
  def __init__(self, filename):
    self.s = BeautifulSoup(open(filename).read(),'html5lib')
    self.title = ''
    self.date_appeared = ''
    self.clues = ''
    self.grid = {}
    self.clues = []
    self.sq = ''
    self.ans = ''
    self.__parse()

  def __sanitize(self,l):
    l = l.replace(u'\u2019', u'\'').replace(u'\u2014', u'--').replace(u'\u2026', u'...').replace(u'\u0022', u'"').replace(u'\u201c', u'"').replace(u'\u201d', u'"')
    return l

  def __get_length(self,l): return eval(punctuations.sub("+",l))


  def __parse(self):
    rows = self.s.find('table',attrs={'id':'crossword-Grid'}).tbody.find_all('tr')
    size = 15
    if ' Jumbo ' in self.s.title.get_text():
      size = 23
    for i,row in enumerate(rows):  
      cols = row.find_all('td')
      for j,col in enumerate(cols):
        number = 0
        letter = ''
        letter_markup = col.find('div', attrs={'class':'crossword-Letter'})
        if letter_markup: letter = letter_markup.get_text()
        number_markup = col.find('span', attrs={'class':'crossword-Number'})
        if number_markup: number = number_markup.get_text()
        self.grid[size*i+j+1] = (number,letter)
    metadata = self.s.title.get_text().split('|')[-1].split('-')
    self.title = metadata[0].strip()
    self.date_appeared = time.strptime(metadata[1].strip(), '%B %d, %Y')
    across = self.s.select('#clueContainer table')[0].tbody.find_all('tr')[1:]
    down = self.s.select('#clueContainer table')[1].tbody.find_all('tr')[1:]


    for c in across:
      m=clue_regex.match(self.__sanitize(c.get_text()))
      clue_number = m.group('number')
      clue_text = m.group('clue')
      clue_length = m.group('length')
      clue = clue_text + ' (' + clue_length + ')'
      l = int(self.__get_length(clue_length))
      box = [(x,self.grid[x]) for x in self.grid if self.grid[x][0]==clue_number].pop()[0]
      answer = ''.join([self.grid[box+x][1] for x in range(l)])
      self.clues.append({'code':clue_number+'A', 'clue':clue, 'answer':answer, 'square':box})

    for c in down:
      m=clue_regex.match(self.__sanitize(c.get_text()))
      clue_number = m.group('number')
      clue_text = m.group('clue')
      clue_length = m.group('length')
      clue = clue_text + ' (' + clue_length + ')'
      l = int(self.__get_length(clue_length))
      box = [(x,self.grid[x]) for x in self.grid if self.grid[x][0]==clue_number].pop()[0]
      answer = ''.join([self.grid[box+size*x][1] for x in range(l)])
      self.clues.append({'code':clue_number+'D', 'clue':clue, 'answer':answer, 'square':box})

    self.sq = ''.join(map(lambda x: '1' if self.grid[x][1] else '0',self.grid))
    self.ans = ''.join(map(lambda x: self.grid[x][1] if self.grid[x][1] else ' ',self.grid))

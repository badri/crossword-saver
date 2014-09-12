#!/usr/bin/python
# -*- coding: iso-8859-15 -*-
'''
TODO:
better regex for multiline clues.
ignore and strip put unicode characters.
'''
import re
import math

clue=re.compile(ur'(?P<number>[0-9]+)[\\.\s]*(?P<clue>[0-9A-Za-z,:;\u2014\u2019\u2026\u201c\u201d\'"\\.\\?!-\\(\\) ]+)\((?P<length>[0-9,-]+)\)')
punctuations = re.compile("(,|-)")

orient = {'A': 'across', 'D': 'down'}

class ClueParseException(Exception):
    def __init__(self, value):
        self.value = value
    def __str__(self):
        return repr(self.value)

class GridValidationException(Exception):
    def __init__(self, value):
        self.value = value
    def __str__(self):
        return repr(self.value)

class InconsistentClueException(Exception):
    def __init__(self, clue, parsed_clue_length, submitted_clue_length):
        self.clue = clue
        self.parsed_clue_length = parsed_clue_length
        self.submitted_clue_length = submitted_clue_length
    def __str__(self):
        return 'submitted clue length %s not matching parsed clue length %s for clue %s' % (self.submitted_clue_length, self.parsed_clue_length, self.clue)


def get_length(l): return eval(punctuations.sub("+",l))


def get_clues(xword,type):
    if type=='A':
        clue_list = [i.strip() for i in xword['across'].split("\n") if i.strip()]        
    if type=='D':
        clue_list = [i.strip() for i in xword['down'].split("\n") if i.strip()]
    parsed_clues = []
    for c in clue_list:
        try:
            m=clue.match(c)
            if not m:
                raise ClueParseException(c)
            else:
                parsed = {}
                clue_number = m.group('number')
                square_key = '%s_%s_N' % (clue_number,type)
                clue_length_key = '%s_%s_' % (clue_number, type)
                if square_key not in xword:
                    raise GridValidationException(square_key)
                if clue_length_key not in xword:
                    raise GridValidationException(clue_length_key)
                parsed['code'] = clue_number+type
                clue_text = m.group('clue')
                parsed['square'] = xword[square_key]
                clue_length = m.group('length')
                submitted_clue_length = xword[clue_length_key]
                if int(submitted_clue_length) != int(get_length(clue_length)):
                    raise InconsistentClueException(clue_text, get_length(clue_length), submitted_clue_length)
                parsed['answer'] = 'x' * int(submitted_clue_length)
                parsed['clue'] = '%s (%s)' % (clue_text, clue_length)
                parsed_clues.append(parsed)
        except ClueParseException as ce:
            print 'Unable to parse clue:', ce
        except GridValidationException as g:
            print 'No square found for key:', g.value
        except InconsistentClueException as i:
            print i
    return parsed_clues

def cw_obj(c):
    if c.square % 15:
        startx = c.square % 15
    else:
        startx = 15
    if c.answer.isdigit():
        answer = 'x' * int(c.answer)        
    else:
        answer = c.answer.lower()
    if int(math.ceil(c.square/float(15))):
        starty = int(math.ceil(c.square/float(15)))
    else:
        starty = 1
    return {"clue": c.clue, "answer": answer, "position": int(c.code[:-1]), "startx": startx, "starty": starty, "orientation": orient[c.code[-1]]}

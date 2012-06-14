#!/usr/bin/python
# -*- coding: iso-8859-15 -*-
import re

clue=re.compile('(?P<number>[0-9]+)[\\.\s]*(?P<clue>[0-9A-Za-z,:;\'"\\.\\?!\\- ]+)\((?P<length>[0-9,-]+)\)')
punctuations = re.compile(",-")


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
        return repr('submitted clue length %d not matching parsed clue length %d for clue %s' % (submitted_clue_length, parsed_clue_length, clue))


def get_length(l): return eval(punctuations.sub("+",l))


def sanitize(l):
    l = l.replace('’','\'').replace('—','--')
    return l

def get_clues(xword,type):
    if type=='A':
        clue_list = [i.strip() for i in xword['across'].split("\n") if i]        
    if type=='D':
        clue_list = [i.strip() for i in xword['down'].split("\n") if i]
    parsed_clues = []
    for c in clue_list:
        try:
            m=clue.match(sanitize(c))
            if not m:
                raise ClueParseException(c)
            else:
                parsed = {}
                clue_number = m.group('number')
                square_key = '%s_%s_N' % (clue_number,type)
                clue_length_key = '%s_%s_' % (clue_number)
                if not xword[square_key]:
                    raise GridValidationException(square_key)
                if not xword[clue_length_key]:
                    raise GridValidationException(clue_length_key)
                parsed['code'] = clue_number
                parsed['clue'] = m.group('clue')
                parsed['square'] = xword[square_key]
                parsed['answer'] = ''
                clue_length = m.group('length')
                submitted_clue_length = xword[clue_length_key]
                if submitted_clue_length != eval(clue_length):
                    raise InconsistentClueException(parsed['clue'], clue_length, submitted_clue_length)
                parsed_clues.append(parsed)
        except ClueParseException as c:
            print 'Unable to parse clue:', c.value
        except GridValidationException as g:
            print 'No square found for key:', g.value
        except InconsistentClueException as i:
            print i
    return parsed_clues

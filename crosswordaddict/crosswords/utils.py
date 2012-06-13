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

def get_length(l): return eval(punctuations.sub("+",l))


def sanitize(l):
    l = l.replace('’','\'').replace('—','--')
    return l

def get_clues(clues):
    clue_list = [i.strip() for i in clues.split("\n") if i]
    parsed_clues = []
    for c in clue_list:
        try:
            m=clue.match(sanitize(c))
            if not m:
                raise ClueParseException(c)
            else:
                parsed = {}
                parsed['code'] = m.group('number')
                parsed['clue'] = m.group('clue')
                parsed['clue_length'] = m.group('length')
                parsed_clues.append(parsed)
        except ClueParseException as c:
            print 'Unable to parse clue:', c.value
    return parsed_clues

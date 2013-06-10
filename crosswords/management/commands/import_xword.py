import time
from datetime import datetime
from django.core.management.base import BaseCommand, CommandError
from crosswords.models import *

class Command(BaseCommand):
    args = '<html file>'
    help = 'Imports times cryptics from html file to db'

    def handle(self, *args, **options):
        filename = args[0]
        from crosswords.times_parse import TimesParser
        p = TimesParser(filename)
        presets = CsPresets(grid=p.sq,name=p.title,appeared=time.strftime('%Y-%m-%d',p.date_appeared))
        presets.save()
        crossword = CsCrossword(gridid=presets.id, dateadded=datetime.now(),user='badri')
        crossword.save()
        for clue in p.clues:
          CsClues(crosswordid=crossword.id, clue=clue['clue'], answer=clue['answer'], code=clue['code'], square=clue['square']).save()
        self.stdout.write('Successfully imported crossword from "%s".\n' % filename)

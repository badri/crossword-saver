# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#     * Rearrange models' order
#     * Make sure each model has one field with primary_key=True
# Feel free to rename the models, but don't rename db_table values or field names.
#
# Also note: You'll have to insert the output of 'django-admin.py sqlcustom [appname]'
# into your database.

from django.db import models
from fields import CrosswordField

class CsClues(models.Model):
    id = models.IntegerField(primary_key=True)
    crosswordid = models.IntegerField(null=True, db_column='crosswordId', blank=True) # Field name made lowercase.
    clue = models.CharField(max_length=300, blank=True)
    answer = models.CharField(max_length=90, blank=True)
    code = models.CharField(max_length=30, blank=True)
    square = models.IntegerField(null=True, blank=True)
    def __unicode__(self):
        return "%s"%(self.clue)
    class Meta:
        db_table = u'cs_clues'

class CsCrossword(models.Model):
    id = models.IntegerField(primary_key=True)
    gridid = CrosswordField(db_column='gridId') # Field name made lowercase.
    complete = models.CharField(max_length=3, blank=True)
    dateadded = models.DateTimeField(db_column='dateAdded') # Field name made lowercase.
    user = models.CharField(max_length=90)
    def __unicode__(self):
        return "%d"%(self.id)
    class Meta:
        db_table = u'cs_crossword'

    def save(self, *args, **kwargs):
        print args
        print kwargs
        super(CsCrossword, self).save(*args, **kwargs) # Call the "real" save() method.


class CsPresets(models.Model):
    id = models.IntegerField(primary_key=True)
    grid = models.TextField(unique=True)
    answers = models.TextField(blank=True)
    def __unicode__(self):
        return "%s"%(self.grid)    
    class Meta:
        db_table = u'cs_presets'

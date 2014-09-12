# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#     * Rearrange models' order
#     * Make sure each model has one field with primary_key=True
# Feel free to rename the models, but don't rename db_table values or field names.
#
# Also note: You'll have to insert the output of 'django-admin.py sqlcustom [appname]'
# into your database.

from django.db import models
from django.core.urlresolvers import reverse
from fields import CrosswordField

class CsClues(models.Model):
    crosswordid = models.IntegerField(null=True, db_column='crosswordId', blank=True) # Field name made lowercase.
    clue = models.CharField(max_length=300, blank=True)
    answer = models.CharField(max_length=90, blank=True) # user specific
    code = models.CharField(max_length=30, blank=True)
    square = models.IntegerField(null=True, blank=True)
    notes = models.TextField(blank=True) # user specific
    def __unicode__(self):
        return "%s"%(self.clue)
    class Meta:
        db_table = u'cs_clues'

class CsCrossword(models.Model):
    gridid = CrosswordField(db_column='gridId') # Field name made lowercase.
    complete = models.CharField(max_length=3, blank=True)
    dateadded = models.DateTimeField(db_column='dateAdded') # Field name made lowercase.
    user = models.CharField(max_length=90)
    def __unicode__(self):
        return "%d"%(self.id)
    class Meta:
        db_table = u'cs_crossword'

    def save(self, *args, **kwargs):
        super(CsCrossword, self).save(*args, **kwargs) # Call the "real" save() method.


class CsPresets(models.Model):
    grid = models.TextField()
    answers = models.TextField(blank=True)
    name = models.CharField(max_length=20, blank=True)
    description = models.TextField(blank=True)
    added = models.DateTimeField(auto_now_add=True)
    appeared = models.DateField(blank=True)

    def __unicode__(self):
        return "%s"%(self.grid)    

    def get_absolute_url(self):
        return reverse('crossword2', args=(self.pk,))

    class Meta:
        db_table = u'cs_presets'

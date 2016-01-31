#path = 'E:\Python_Data\province.txt'
#open(path).readline()

import json
path = 'E:\Python_Data\province.txt'
records = [json.loads(line) for line in open(path)]
#print records[1]
time_zones = [rec['tz'] for rec in records if 'tz' in rec]
#print time_zones[5:10]

def get_counts(sequence):
    counts = {}
    for x in sequence:
        if x in counts:
            counts[x] += 1
        else:
            counts[x] = 1
    return counts
    
#counts = get_counts(time_zones);   
#print counts 

from collections import defaultdict
def get_counts2(sequence):
    counts = defaultdict(int)
    for x in sequence:
        counts[x] += 1
    return counts
    
#counts = get_counts2(time_zones);
#print len(counts)

def top_counts(count_dict, n=10):
    value_key_pairs = [(count, tz) for tz, count in count_dict.items()]
    value_key_pairs.sort()
    return value_key_pairs[-n:]

#top = top_counts(counts)
#print top

from collections import Counter
counts = Counter(time_zones);
counts.most_common(10); 
#print counts

#import matplotlib
from pandas import DataFrame, Series
import pandas as pd
import numpy as np
from pylab import *

frame = DataFrame(records);

#print frame['tz']
#tz_count = frame['tz'].value_counts()
#print tz_count[:20]

clean_tz = frame['tz'].fillna('Missing')
clean_tz[clean_tz == ''] = 'Unknown'
tz_counts = clean_tz.value_counts()
#tz_counts[:10].plot(kind='barh', rot=0)

#show()

#print frame['a'][1]

results = Series([x.split()[0] for x in frame.a.dropna()])
#print results[:5]
cframe = frame[frame.a.notnull()]
operation_system = np.where(cframe['a'].str.contains('Windows'), 'Window', 'Not Window')
#print operation_system

by_tz_os = cframe.groupby(['tz', operation_system])
agg_count = by_tz_os.size().unstack().fillna(0)
print agg_count[:10]

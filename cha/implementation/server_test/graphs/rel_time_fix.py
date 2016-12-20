import begin
import datetime

@begin.start
def main(*infile):
    for file in infile:
        lines = []
        s_t = None
        with open(file) as f:
            header = f.readline().strip()
            for i, line in enumerate(f):
                if i is 0:
                    s_t = datetime.datetime.strptime(line.split(";")[0], "%H:%M:%S,0")
                t = datetime.datetime.strptime(line.split(";")[0], "%H:%M:%S,0") - s_t
                lines.append((str(t), ';'.join(line.split(";")[1:]).strip()))
        with open(file, "w") as f:
            print(header, file=f)
            for line in lines:
                print("{};{}".format(*line), file=f)


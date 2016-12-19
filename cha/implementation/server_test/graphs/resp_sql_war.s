set term epslatex size 5.50in, 4.00in
set xdata time
set timefmt "%H:%M:%S,0"
set output 'resp_sql_war.tex'
set ylabel 'Response times in ms' offset 2
set xlabel 'Elapsed time in minutes'
set title ''
set datafile separator ";"
set border 3
set ytics out nomirror
set xtics out nomirror rotate by -45
set format x "%M"
set grid ytics lc rgb "#88607D8B" lw 1 lt 1
plot 'nosql_resp.csv' using 1:2 with lines t 'NoSQL' lc rgb "#03A9F4" lw 3,\
     'sql_resp.csv'   using 1:2 with lines t 'SQL w/ indices' lc rgb "#BF360C" lw 3

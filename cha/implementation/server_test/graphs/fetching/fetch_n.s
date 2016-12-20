set term epslatex size 5.50in, 4.00in
set output 'fetch_normal.tex'
set xdata time
set timefmt "%H:%M:%S,0"
set ylabel 'Response times in ms' offset 2
set xlabel 'Elapsed time [seconds]'
set title ''
set datafile separator ";"
set border 3
set ytics out nomirror
set xtics out nomirror rotate by -45
set format x "%S"
set key above width -15 vertical maxrows 3
set grid ytics lc rgb "#88607D8B" lw 1 lt 1
plot 'all_users.csv' using 1:2 with lines t 'All users 516.8 MB' lc rgb "#263238" lw 3,\
     'all_routes.csv' using 1:2 with lines t 'All routes 178.3 MB' lc rgb "#1B5E20" lw 3,\
     'routes_4_driver.csv' using 1:3 with lines t 'Routes for random drivers 0.625 MB' lc rgb "#BF360C" lw 3,\
     'all_vehicles.csv' using 1:2 with lines t 'All vehicles 159.6 MB' lc rgb "#0D47A1" lw 3,\
     'geospatial.csv' using 1:2 with lines t 'Geospatial 1.296 MB' lc rgb "#4A148C" lw 3

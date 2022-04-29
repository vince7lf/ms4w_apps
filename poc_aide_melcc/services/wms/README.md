# WMS Service for AIDE

## Requête pour tester les capacités WMS du serveur

<http://127.0.0.1:8787/cgi-bin/mapserv.exe?map=/ms4w/apps/poc_aide_melcc/services/wms/aide_wms_service.map&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetCapabilities>

## Requête pour tester le GetMap  du service WMS

<http://127.0.0.1:8787/cgi-bin/mapserv.exe?map=/ms4w/apps/poc_aide_melcc/services/wms/aide_wms_service.map&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetCapabilities>

## Apache Custom WMS mapserver Environment

In the Apache's _httpd.conf_ file `C:\ms4w\Apache\conf\httpd.conf`

```
<IfModule alias_module>
 
...

    ##
    ## Alias for MapServer
    ##
    Alias /ms_tmp/ "C:/ms4w/tmp/ms_tmp/"      
    Alias /tutorial/ "C:/ms4w/apps/tutorial/htdocs/"
    Alias /poc_aide_melcc/ "C:/ms4w/apps/poc_aide_melcc/"
    Alias /wms "C:/ms4w/Apache/cgi-bin/mapserv.exe"

</IfModule>

...

<Location "/wms">
   SetHandler cgi-script
   Options ExecCGI
    # Specific MapServer environment
    # refer to <https://www.mapserver.org/optimization/environment_variables.html#environment-variables>
    SetEnv MS_MAP_PATTERN "^(C:)?\/ms4w\/apps\/((?!\.{2})[_A-Za-z0-9\-\.]+\/{1})*([_A-Za-z0-9\-\.]+\.(map))$"
    SetEnv MS_MAP_NO_PATH "any_value_is_ok"
    SetEnv AIDE_WMS_MAP_SERVICE "/ms4w/apps/poc_aide_melcc/services/wms/aide_wms_service.map"
    SetEnv MS_MAPFILE "/ms4w/apps/poc_aide_melcc/services/wms/aide_wms_service.map"
    # do not set the MODE here as the test of the GetCapabilities will fail
    # SetEnv MS_MODE "map"
    SetEnv MS_ERRORFILE "C:/ms4w/tmp/ms_error.txt"
    SetEnv MS_DEBUGLEVEL 1
</Location>

```

### Tests

> _Note_ : Return the WMS service capabilities. In a web browser, it will download a file (mapserv.exe or wms) whitch is an xml file. In QGIS, it will retrieve the different layers available.

| | |
|:-|:-|
| <http://127.0.0.1:8787/cgi-bin/mapserv.exe?map=/ms4w/apps/poc_aide_melcc/services/wms/aide_wms_service.map&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetCapabilities> | Return the WMS service capabilities with no customization of the Apache httpd.conf. |
| <http://127.0.0.1:8787/cgi-bin/mapserv.exe?map=AIDE_WMS_MAP_SERVICE&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetCapabilities> | Return the WMS service capabilities with the _map=mapfile_ path obfuscated by an alias, set in the Apache _httpd.conf_. |
| <http://127.0.0.1:8787/wms?map=AIDE_WMS_MAP_SERVICE&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetCapabilities> | Return the WMS service capabilities with the _cgi-bin/mapserv.exe_ webpath mapfile path obfuscated by an alias, set in the Apache _httpd.conf_. |
| <http://127.0.0.1:8787/wms?SERVICE=WMS&VERSION=1.1.1&REQUEST=GetCapabilities> | Return the WMS service capabilities with the _map=mapfile_ set in the Apache _httpd.conf_. |

> _Note_: Will display an image of the Québec province in red.

| | |
|:-|:-|
| <http://127.0.0.1:8787/wms?mode=map&layer=province> | Returns the province of Qubec as an image, with multiple properties set in the Apache _httpd.conf_. |

## STYLES

Source : <https://www.nrcan.gc.ca/earth-sciences/geomatics/canadas-spatial-data-infrastructure/standards-policies/8938>


* STYLES: provide a comma-separated list of style names. There must be a one-to-one correspondence between the values in the LAYERS parameter and the values in the STYLES parameter.

## BBOX

Source : <https://www.nrcan.gc.ca/earth-sciences/geomatics/canadas-spatial-data-infrastructure/standards-policies/8938>

* BBOX: minx, miny, maxx, maxy – to specify the coordinates of bounding box corners in the  SRS. This defines the spatial boundary to be used for map generation.

## WIDTH and HEIGHT

Source : <https://www.nrcan.gc.ca/earth-sciences/geomatics/canadas-spatial-data-infrastructure/standards-policies/8938>

* WIDTH, HEIGHT: numbers to specify the size of the map in pixels. These parameters are only used for maps returned in picture formats. If the WIDTH /HEIGHT ratio is different from the ratio specified by the  BBOX, the server must re-render the map to fit in the WIDTH and HEIGHT picture frame. If a layer is declared to have fixed width and height, the server will only accept the declared numbers, and will issue a Service Exception for any other numbers.

## WMS services using imagetype application/openlayers

TODO

# Notes

### Easting, Northing, lat, lon, x, y 

Refer to <https://www.mapserver.org/ogc/wms_server.html#coordinate-systems-and-axis-orientation>

WMS 1.3.0 specifies that, depending on the particular CRS, the x axis may or may not be oriented West-to-East, and the y axis may or may not be oriented South-to-North.

* easting (x or lon )
* northing (y or lat)

# Map server utilities

## In Windows

Open a command line from the installation folder of mapserver.

Execute setenv.bat.

```
c:\ms4w>setenv.bat
mapserv, GDAL, Python, PHP, and commandline MS4W tools path set
```

Execute mapserv -v to check the capabilities of mapserver.

```
c:\ms4w>mapserv.exe -v
MapServer version 7.7.0-dev (MS4W 4.0.5) OUTPUT=PNG OUTPUT=JPEG OUTPUT=KML SUPPORTS=PROJ SUPPORTS=AGG SUPPORTS=FREETYPE SUPPORTS=CAIRO SUPPORTS=SVG_SYMBOLS SUPPORTS=SVGCAIRO SUPPORTS=ICONV SUPPORTS=FRIBIDI SUPPORTS=WMS_SERVER SUPPORTS=WMS_CLIENT SUPPORTS=WFS_SERVER SUPPORTS=WFS_CLIENT SUPPORTS=WCS_SERVER SUPPORTS=SOS_SERVER SUPPORTS=FASTCGI SUPPORTS=THREADS SUPPORTS=GEOS SUPPORTS=POINT_Z_M SUPPORTS=PBF INPUT=JPEG INPUT=POSTGIS INPUT=OGR INPUT=GDAL INPUT=SHAPEFILE
```

## test the map file

Source : <https://gis.stackexchange.com/questions/425277/qgis-3-24-and-3-18-cant-load-wfs-layer-from-mapserver-ms4w>

Make sure that your data is showing properly with shp2img commandline utility 

```
c:\ms4w>shp2img -m c:\ms4w\apps\poc_aide_melcc\services\wfs\aide_wfs_service.map -o c:\ms4w\apps\poc_aide_melcc\services\wfs\aide_wfs_service.png -all_debug 3
[Thu Apr 28 20:24:54 2022].964000: GDAL: In GDALDestroy - unloading GDAL shared library.
```

Once your data is appearing properly there, execute a GetCapabilities request, and examine the response. 

Remove any 'warning' messages.
      
        <div class="left-cont" style="border-right:1px solid #e1e1e1;">
            <form>
                <div class="search-icon"><label> <i class="fa fa-search"></i> </label>   <input class="no-css zoeken-box-website" id="search-form" type="search" placeholder="Zoeken op trefwoord" value="" name="Search by keyword" /></div>
                <select  class="zoeken-box-website" id='brand' >
                    <option value='' selected >Merk / Model</option> 
                    <option value="">Carrosserie</option><option value="MPV">MPV</option><option value="Hatchback">Hatchback</option>
                </select>
                <input class="zoeken-box-website" type="text" id="prijs-van" placeholder="Prijs van" name="prijs-van" />
                <input  class="zoeken-box-website" type="text" id="prijs-tot" placeholder="Prijs van" name="prijs-tot" />
                <input class="zoeken-box-website" value='' type="text" id="year1" placeholder="Bouwjaar van" name="year1" />
                <input  class="zoeken-box-website" value='' type="text" id="year2" placeholder="Bouwjaar tot" name="year2" />
                <input class="zoeken-box-website" value='' type="text" id="kmstand-van" placeholder="kmstand van" name="kmstand-van" />
                <input class="zoeken-box-website" value='' type="text" id="kmstand-tot" placeholder="kmstand tot" name="kmstand-tot" />
                <select  class="zoeken-box-website" id="carrosserie" name="carrosserie">
                    <option value=''>Carrosserie</option>     
                </select>
                <select   class="zoeken-box-website" id="zitplaatsen" name="zitplaatsen">
                    <option value=''>Zitplaatsen</option>
                    <option value="1">1</option>
                    <option value="2" >2</option>
                    <option value="3" >3</option>
                    <option value="4" >4</option>
                    <option value="5" >5</option>
                    <option value="6" >6</option>
                    <option value="7" >7</option>
                    <option value="8" >8</option>
                    <option value="9" >9</option>
                    <option value="10" >10</option>
                    <option value="11" >More</option>
                </select>
                <select   class="zoeken-box-website" id="aantal-deuren" name="aantal-deuren" >
                    <option value='' >Aantal deuren</option>
                    <option value="1">1</option>
                    <option value="2" >2</option>
                    <option value="3" >3</option>
                    <option value="4" >4</option>
                    <option value="5" >5</option>
                    <option value="6" >6</option>
                    <option value="7" >7</option>
                    <option value="8" >8</option>
                    <option value="9" >9</option>
                    <option value="10" >10</option>
                    <option value="11" >More</option>
                </select>
                <select   class="zoeken-box-website" id="transmissie" name="transmissie">
                    <option value="" >Transmissie</option>     
                </select>
                <select   class="zoeken-box-website" id="brandstof" name="brandstof">
                    <option value='' >Brandstof</option>     
                </select>
            </form>

            <input onclick="reset()" id="reset-button" type="button" class="button-left" value="Reset">
            <input type="button" id="search-button" class="button-right-last" value="Zoeken">
        </div>
        
        
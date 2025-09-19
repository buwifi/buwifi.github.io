# _plugins/category_pagination.rb
module Jekyll
  class TaxonomyPageGenerator < Generator
    safe true

    def generate(site)
      generate_taxonomy_pages(site, site.categories, 'categories')
      generate_taxonomy_pages(site, site.tags, 'tags')
    end

    def generate_taxonomy_pages(site, taxonomy, type)
      taxonomy.each do |name, posts|
        next if posts.empty?

        per_page = site.config['pagination'] && site.config['pagination']['per_page'] || 4
        total_pages = (posts.size.to_f / per_page).ceil
        slug = name.downcase  # Force lowercase for URL

        (1..total_pages).each do |page_num|
          site.pages << TaxonomyPage.new(site, site.source, type, name, slug, posts, page_num, per_page, total_pages)
        end
      end
    end
  end

  class TaxonomyPage < Page
    attr_reader :paginator

    def initialize(site, base, type, name, slug, posts, page_num, per_page, total_pages)
      @site = site
      @base = base
      @dir  = page_num == 1 ? "#{type}/#{slug}" : "#{type}/#{slug}/page#{page_num}"
      @name = 'index.html'

      self.process(@name)
      self.read_yaml(File.join(base, '_layouts'), "#{type.singularize}_index.html")

      self.data['title'] = name.capitalize
      self.data['slug'] = slug
      self.data['type'] = type
      self.data['paginator'] = {
        'page' => page_num,
        'per_page' => per_page,
        'posts' => posts.slice((page_num-1)*per_page, per_page) || [],
        'total_posts' => posts.size,
        'total_pages' => total_pages,
        'previous_page' => page_num > 1 ? page_num-1 : nil,
        'next_page' => page_num < total_pages ? page_num+1 : nil,
        'previous_page_path' => page_num > 2 ? "/#{type}/#{slug}/page#{page_num-1}/" : "/#{type}/#{slug}/",
        'next_page_path' => page_num < total_pages ? "/#{type}/#{slug}/page#{page_num+1}/" : nil
      }
    end
  end
end
